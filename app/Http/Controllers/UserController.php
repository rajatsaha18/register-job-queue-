<?php

namespace App\Http\Controllers;

use App\Jobs\SendWelcomeEmailJob;
use App\Models\User;
use Illuminate\Http\Request;



class UserController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('password')
        ]);

        // job dispatch
        SendWelcomeEmailJob::dispatch($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User registered & email queued',
        ]);

    }
}
