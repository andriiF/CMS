<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class AdminLoginController extends Controller {

    use AuthenticatesUsers;

    public function __construct() {
        $this->middleware('guest:users')->except('logout');
    }

    public function showLoginForm() {
        return view('admin.auth.login');
    }

    public function login(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::guard('users')->attempt([
                    'email' => $request->email,
                    'password' => $request->password,
                        ], $request->remember)) {
            return redirect()->intended(route('admin.dashboard'));
        }
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout() {
        Auth::guard('admin')->logout();
        return redirect('/');
    }

}
