<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->intended('home');
        }
    
        return redirect()->route('home')->with('error', 'As credenciais informadas estão incorretas.');
    }
    

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
