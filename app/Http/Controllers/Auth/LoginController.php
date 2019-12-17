<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /* định nghĩa phương thức redirectTo */
    protected function redirectTo()
    {
        $user = Auth::user();
        if ($user->group_id == 1)
            return '/admin/dashboard';
        else return '/';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticate(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::attempt(['email' => $request->email_or_phone, 'password' => $request->password, 'actived'=>1])) {
                return Response::json(['success'=>true]);
            } elseif (Auth::attempt(['phone' => $request->email_or_phone, 'password' => $request->password, 'actived'=>1]))
                return Response::json(['success' => true]);
            else return Response::json(['success' => false]);
        }
        return false;
    }
}
