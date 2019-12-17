<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;

class AdminAuthController extends Controller
{

    use AuthenticatesUsers;

//    overide hiện form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        if (Auth::attempt(['email' => $request->email_or_phone, 'password' => $request->password, 'actived'=>1])) {
            return redirect()->intended('/admin/dashboard');
        } elseif (Auth::attempt(['phone' => $request->email_or_phone, 'password' => $request->password, 'actived'=>1]))
            return redirect()->intended('/admin/dashboard');
        else {
            return back()->withErrors([__('auth.failed')]);
        }
    }


}