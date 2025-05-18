<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('log_in');
    }

    public function showRegistrationForm()
    {
    return view('admin.new_user.registration');
    }


    public function login(Request $request)
    {
        $credetials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credetials)){
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Nesprávne prihlasovacie údaje.',
        ])->onlyInput('email');
    }

public function register(Request $request)
{

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|',
        'role' => 'required|string|in:admin,user|max:255',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => $validated['role'],
    ]);

    session()->flash('success', 'Účet vytvorený');
    return redirect()->back()->with('success', 'Účet vytvorený');
}


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
