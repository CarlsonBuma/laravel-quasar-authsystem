<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class CreateAccountController extends Controller
{
    /**
     ** Registration / Create Account
     **  > Creates new User
     **  > Verified: Null
     **  > Verification Request must be executed manually by user
     *
     * @param Request $request
     * @return void
     */
    public function register(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => ['required', 'string', 'max:125'],
                'email' => ['required', 'string', 'email', 'unique:users', 'max:255'],
                'terms' => ['required', 'boolean'],
            ]);
    
            if(!$data['terms']) throw new Exception('Please accept our terms & conditions.');

            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' =>  Hash::make(Str::random(125))
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errorType' => 'email'
            ], 422);
        }
        
        return response()->json([
            'message' => 'Success! Your account has been created.',
        ], 200);
    }
}
