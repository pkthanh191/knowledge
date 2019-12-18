<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Helper;
use App\Libs\NganLuong\Checkout\NL_MicroCheckout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Flash;
use App\Libs\NganLuong\MobiCard;
use App\Repositories\UserRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\TutorialRepository;
use App\Repositories\TutorialCodeRepository;
use Illuminate\Support\Facades\Response;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;

class RechargeController extends Controller
{
    protected $mobiCard;
    private $userRepository;
    private $transactionRepository;
    private $tutorialRepository;
    private $tutorialCodeRepository;
    protected $mailer;

    function __construct(MobiCard $mobiCard, UserRepository $userRepo, TransactionRepository $transactionRepo, TutorialRepository $tutorialRepo, TutorialCodeRepository $tutorialCodeRepo, Mailer $mailer)
    {
        $this->mobiCard = $mobiCard;
        $this->userRepository = $userRepo;
        $this->transactionRepository = $transactionRepo;
        $this->tutorialRepository = $tutorialRepo;
        $this->tutorialCodeRepository = $tutorialCodeRepo;
        $this->mailer = $mailer;
    }

    public function check_user(Request $request)
    {
        $email = $request['email'];
        $phone = $request['phone'];
        $user = $this->userRepository->findByField('email', '=', $email)->first();
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return Response::json($validator->messages());
        }
        //Nếu thông tin nhập vào là người dùng trong hệ thống thì bật ra thông báo bắt đăng nhập
        if ($user) {
            return Response::json(['user' => $user]);
        } else {
            return Response::json(['fail' => true]);
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255',
            'phone' => array('required', 'regex:/^(09)[0-9]{8}$|^(03)[0-9]{8}$|^(05)[0-9]{8}$|^(07)[0-9]{8}$|^(08)[0-9]{8}$/','unique:users'),
        ], [], User::attributes());
    }

    public function recharge(Request $request)
    {
        $serial = $request['serial'];
        $pin = $request['pin'];
        $type = $request['select_method'];

        $arytype = array(92 => 'VMS', 93 => 'VNP', 107 => 'VIETTEL', 120 => 'GATE');
        //Tiến hành kết nối thanh toán Thẻ cào.
        $coin1 = rand(10, 999);
        $coin2 = rand(0, 999);
        $coin3 = rand(0, 999);
        $coin4 = rand(0, 999);
        $ref_code = $coin4 + $coin3 * 1000 + $coin2 * 1000000 + $coin1 * 100000000;

        $rs = $this->mobiCard->CardPay($pin, $serial, $type, $ref_code, "", "", "");

        if ($rs->error_code == '00') {
            $amount = $rs->card_amount;
            $earn = Helper::exchangeVNDtoKnow($amount);
            if (Auth::check()) {
                $user = Auth::user();
                $user->account_balance += $earn;
                $user->save();
                $input = [
                    'trans_card_type' => $rs->type_card,
                    'real_value' => $amount,
                    'money_transfer' => $earn,
                    'content' => Helper::$TRANS_RECHARGE_CARD,
                    'status' => '1',
                    'user_id' => $user->id,
                    'trans_id' => $rs->transaction_id,
                ];
                $this->transactionRepository->create($input);
                $result = array(
                    'user' => $user,
                    'amount' => $amount,
                    'earn' => $earn,
                    'total' => $user->account_balance,
                    'know_tutorial' => config('system.minus-knows-tutorial.value'),
                );
                Flash::success(__('messages.recharge_success') . Helper::format_money($amount) . '. ' .
                    __('messages.recharge_earn') . Helper::format_money($earn, true, ' KNOW') .
                    __('messages.recharge_know') . '.');
                return Response::json($result);
            } else {
                $email = $request['info_email'];
                $phone = $request['info_phone'];
                //Trường hợp không phải user trong hệ thống thì tạo mới User

                if (strpos($phone, '+84') !== false) {
                    $phone = str_replace('+84', '0', $phone);
                }
                $input['name'] = $phone;
                $input['email'] = $email;
                $input['phone'] = $phone;
                $input['avatar'] = '/public/uploads/default-avatar.png';
                $pass = Helper::generateRandomString(10);
                $password = Hash::make($pass);
                $input['password'] = $password;
                $input['account_balance'] = $earn;
                $input['actived'] = 1;
                $user = $this->userRepository->create($input);
                $this->transactionRepository->create([
                    'money_transfer' => $earn,
                    'content' => Helper::$TRANS_RECHARGE_CARD,
                    'status' => 1,
                    'user_id' => $user->id,
                    'trans_email' => $email,
                    'trans_phone' => $phone,
                    'real_value' => $amount,
                ]);
                $username = $user->name;
                $user_phone = $user->phone;
                $user_pass = $pass;

                if ($user->account_balance >= config('system.minus-knows-tutorial.value')) {
                    $enoughMoney = true;
                    $user->account_balance -= config('system.minus-knows-tutorial.value');
                    $user->save();
                    $user_account_balance = $user->account_balance;
                    $tutorial = $this->tutorialRepository->find($request['tutorial_id']);
                    $this->transactionRepository->create([
                        'user_id' => $user->id,
                        'money_transfer' => config('system.minus-knows-tutorial.value'),
                        'content' => Helper::$TRANS_VIEW_TUTORIAL,
                        'status' => 1,
                        'trans_email' => $email,
                        'trans_phone' => $phone,
                        'tutorial_id' => $tutorial->id
                    ]);
                    $tutorial_title = $tutorial->title;
                    $code = Helper::generateTel(6);
                    $this->tutorialCodeRepository->create([
                        'code' => $code,
                        'start_date' => time(),
                        'end_date' => time() + 60 * 60 * 24 * config('system.time-effect.value'),
                        'tutorial_id' => $tutorial->id
                    ]);

                    $this->mailer->send(['html' => 'emails.noti_create_user'], compact('tutorial_title', 'code', 'amount', 'earn', 'username', 'user_pass', 'user_phone', 'enoughMoney', 'user_account_balance'), function (Message $m) use ($email) {
                        $m->to($email)->subject(__('messages.subject_receive_code'));
                    });
                } else {
                    $user_account_balance = $user->account_balance;
                    $enoughMoney = false;
                    $moneyMiss = config('system.minus-knows-tutorial.value') - $user->account_balance;
                    $this->mailer->send(['html' => 'emails.noti_create_user'], compact('amount', 'earn', 'moneyMiss', 'enoughMoney', 'username', 'user_pass', 'user_phone', 'user_account_balance'), function (Message $m) use ($email) {
                        $m->to($email)->subject(__('messages.subject_receive_code'));
                    });
                    $result = array(
                        'amount' => $amount,
                        'earn' => $earn,
                        'account_balance' => $user_account_balance,
                        'know_tutorial' => config('system.minus-knows-tutorial.value')
                    );
                    return Response::json($result);
                }
                $result = array(
                    'amount' => $amount,
                    'earn' => $earn,
                );
                return Response::json($result);
            }
        } else {
            return Response::json(['fail' => true,
                'error' => $rs->error_message,
                'code' => $rs->error_code]);
        }
    }

    public function payment_success(Request $request)
    {

        $obj = new NL_MicroCheckout(config('checkout.MERCHANT_ID'), config('checkout.MERCHANT_PASS'), config('checkout.URL_WS'));


        if ($obj->checkReturnUrlAuto()) {
            $inputs = array(
                'token' => $obj->getTokenCode(),//$token_code,
            );

            $result = $obj->getExpressCheckout($inputs);

            if ($result != false) {
                if ($result['result_code'] == '00') {
//                    dd($result);
                    $user = Auth::user();
                    $earn = Helper::exchangeVNDtoKnow($result['amount']);
                    $user->account_balance += $earn;
                    $user->save();

                    $in = [
                        'user_id' => $user->id,
                        'money_transfer' => $earn,
                        'content' => '1',
                        'status' => '1',
                        'trans_id' => $result['transaction_id'],
                        'trans_type' => $result['transaction_type'],
                        'trans_status' => $result['transaction_status'],
                        'trans_email' => $result['payer_email'],
                        'trans_phone' => $result['payer_mobile'],
                        'trans_payment_name' => $result['method_payment_name'],
                        'trans_fee' => $result['fee'],
                        'real_value' => $result['amount']
                    ];

                    $this->transactionRepository->create($in);

                    if ($request['inner_user']) {
                        Flash::success("Bạn đã nạp thành công " . $result['amount'] . "đ. Bạn nhận được " . $earn . ' KNOW  vào trong tài khoản'); //$total_results; $rs->card_amount
                    }
                    return redirect(route('users'));
                } else {
                    Flash::error('Mã lỗi: ' . $result['result_description']);
                    return redirect(route('users'));
                }
            } else {
                Flash::error('Lỗi kết nối tới cổng thanh toán Ngân Lượng');
            }
        } else {
            Flash::error('Tham số truyền không đúng');
        }
        return redirect('users');
    }

    public function checkout(Request $request)
    {
        $inputs = array(
            'receiver' => config('checkout.RECEIVER'),
            'order_code' => 'DH-' . date('His-dmY'),
            'return_url' => route('payment_success'),
            'cancel_url' => '',
            'language' => 'vn'
        );


        $obj = new NL_MicroCheckout(config('checkout.MERCHANT_ID'), config('checkout.MERCHANT_PASS'), config('checkout.URL_WS'));
        $result = $obj->setExpressCheckoutDeposit($inputs);

        if ($result != false) {
            if ($result['result_code'] == '07') {
                $link_checkout = $result['link_checkout'];
                $link_checkout = str_replace('micro_checkout.php?token=', 'index.php?portal=checkout&page=micro_checkout&token_code=', $link_checkout);
                $link_checkout .= '&payment_option=nganluong';
            } else {
                die('Ma loi ' . $result['result_code'] . ' (' . $result['result_description'] . ') ');
            }
        } else {
            die('Loi ket noi toi cong thanh toan ngan luong');
        }

//        $GLOBALS['checkout_url'] = $link_checkout;
//        return view('frontend.recharge.checkout', compact('link_checkout'));
        return $link_checkout;
    }
}
