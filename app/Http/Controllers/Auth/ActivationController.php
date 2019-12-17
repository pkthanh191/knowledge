<?php
/**
 * Created by PhpStorm.
 * User: LamThinh
 * Date: 7/20/2017
 * Time: 11:51 AM
 */

namespace App\Http\Controllers\Auth;

use App\Helpers\Helper;
use App\Repositories\TransactionRepository;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\ActivationService;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ActivationController
{
    protected $activationService;
    protected $transactionRepository;

    use RegistersUsers;

    public function __construct(ActivationService $activationService, TransactionRepository $transactionRepository)
    {
        $this->activationService = $activationService;
        $this->transactionRepository = $transactionRepository;
    }

    public function register(Request $request)
    {
        if (strpos($request['phone'], '+84') === 0)
            $request['phone'] = str_replace('+84', '0', $request['phone']);

        $validator = $this->validator($request->all());
        if ($validator->fails())
            return Response::json($validator->messages());

        $user = $this->create($request->all());
        $this->transactionRepository->create([
            'content' => Helper::$TRANS_NEW_ACCOUNT,
            'money_transfer' => 50,
            'status' => 1,
            'user_id' => $user->id,
        ]);

        $this->activationService->sendActivationMail($user);

        return Response::json(['success' => true]);
    }

    public function activateUser($token)
    {
        if ($user = $this->activationService->activateUser($token)) {
            auth()->login($user);
            return redirect(route('home'));
        }
        abort(404);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => array('required', 'regex:/^(09)[0-9]{8}$|^(03)[0-9]{8}$|^(05)[0-9]{8}$|^(07)[0-9]{8}$|^(08)[0-9]{8}$/', 'unique:users'),
            'password' => 'required|string|min:6|confirmed|max:20',
        ], [], User::attributes());
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
            'group_id' => 2,
            'account_balance' => 50,
            'actived' => 2,
        ]);
    }
}