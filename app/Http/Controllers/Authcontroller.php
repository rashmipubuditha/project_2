<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class Authcontroller extends Controller
{
    //
    public function register(Request $request)
{

    echo "Hello";
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ]);
    

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return response()->json(['message' => 'User registered successfully!'], 201);
}

public function login(Request $request)
{
    echo "Hii";
    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);
    // Attempt to authenticate the user
    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
    return response()->json(['message' => 'Login successful!', 'user' => $user], 200);
}

}
