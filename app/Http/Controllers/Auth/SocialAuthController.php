<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helper;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;

class SocialAuthController extends Controller
{
    private $userRepository;
    private $transactionRepository;

    function __construct(UserRepository $userRepo, TransactionRepository $transactionRepository)
    {
        $this->userRepository = $userRepo;
        $this->transactionRepository = $transactionRepository;
    }

    public function redirectFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackFacebook()
    {
        try {
            $providerUser = Socialite::driver('facebook')->user();
            $user = User::where('email', '=', $providerUser->email)->orWhere('social_id', '=', $providerUser->id)->first();
            if (!$user) {
                return redirect('/')->with('modal_auth', true)->with('user', $providerUser);
            }
            if (!$user->social_id) {
                $user->social_id = $providerUser->id;
                $user->save();
            }
            Auth::login($user);
            return redirect(route('home'));
        } catch (\Exception $e){
            return redirect('/');
        }
    }

    public function callbackGoogle()
    {
        try {
            $providerUser = Socialite::driver('google')->user();
            $user = User::where('email','=',$providerUser->email)->orWhere('social_id','=',$providerUser->id)->first();
            if (!$user) {
                return redirect('/')->with('modal_auth', true)->with('user', $providerUser);
            }
            Auth::login($user);
            return redirect(route('home'));
        } catch (\Exception $e){
            return redirect('/');
        }
    }

    public function authEmail(Request $request)
    {
        if (strpos($request['phone'], '+84') !== false)
            $request['phone'] = str_replace('+84', '0', $request['phone']);
        if (strpos($request['avatar'], 'type=normal') !== false)
            $request['avatar'] = str_replace('type=normal', 'type=large', $request['avatar']);
        $validator = $this->validator($request->all());
        if($validator->fails())
            return Response::json($validator->messages());
        $user = $this->userRepository->create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'group_id' => 2,
            'phone' => $request['phone'],
            'account_balance' => 50,
            'actived' => 1,
            'avatar' => $request['avatar'],
            'social_id' => $request['social_id'],
        ]);
        $this->transactionRepository->create([
            'content' => Helper::$TRANS_NEW_ACCOUNT,
            'money_transfer' => 50,
            'status' => 1,
            'user_id' => $user->id,
        ]);
        if (!$user) {
            return false;
        }
        Auth::login($user);
        return Response::json(['success' => true]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => array('required', 'regex:/^(09)[0-9]{8}$|^(03)[0-9]{8}$|^(05)[0-9]{8}$|^(07)[0-9]{8}$|^(08)[0-9]{8}$/', 'unique:users'),
            'password' => 'required|max:20|min:6|confirmed'
        ], [], User::attributes());
    }
}
