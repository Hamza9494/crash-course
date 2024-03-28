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
}
