<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'email' => 'required|string|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $validate['name'],
            'username' => $validate['username'],
            'email' => $validate['email'],
            'password' => Hash::make($validate['password'])
        ]);

        Cart::create([
            'user_id' => $user->id
        ]);

        return redirect('/login');
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8'
        ]);
        if (Auth::attempt($validate))
        {
            $request->session()->regenerate();

            if ($request->user()->role && $request->user()->role->name === 'admin')
            {
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->flush();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
