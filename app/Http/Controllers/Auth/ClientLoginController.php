<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class ClientLoginController extends Controller {

    use AuthenticatesUsers;

    public function __construct() {
        $this->middleware('guest:client')->except('logout');
    }

    public function showLoginForm() {
        return view('panel.auth.login');
    }

    public function login(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
       
        if (Auth::guard('users')->attempt([//change
                    'email' => $request->email,
                    'password' => $request->password,
                        ], $request->remember)) {
            return redirect()->intended(route('panel.home'));
        }
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout() {
        Auth::guard('admin')->logout();
        return redirect('/');
    }

}
