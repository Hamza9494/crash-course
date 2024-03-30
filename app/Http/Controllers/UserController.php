<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        return view('users.register');
    }

    public function store()
    {
        $validated = request()->validate([
            'name' => 'min:4|max:18|required',
            'email' => 'email|required|unique:users',
            'password' => 'min:4|required|confirmed',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        auth()->login($user);

        return redirect('/')->with('success', 'Account created successfully and logged in');
    }

    public function logout()
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/')->with('success', 'user logged out successfully!');
    }

    public function login()
    {
        return view('users.login');
    }

    public function authenticate()
    {
        $validated = request()->validate([

            'email' => 'email|required',
            'password' => ' required  ',
        ]);

        if (auth()->attempt($validated)) {
            request()->session()->regenerate();

            return redirect('/')->with('success', 'Logged in Successfully');
        }
        return back()->withErrors(['email' => 'invalid credentials'])->onlyInput('email');
    }
}
