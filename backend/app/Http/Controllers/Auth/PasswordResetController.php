<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use App\Modules\Modulate;
use App\Modules\Password;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SendPasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    /**
     ** Send Reset Email
     **  > Generate URL, with Token 
     **  > Send verification link to new email
     * @param Request $request
     * @return void
     */
    public function sendToken(Request $request)
    {
        try {
            $data = $request->validate([
                'email' => ['required', 'email'],
            ]);

            // Create Reset Token
            $user = User::where('email', $data['email'])->first();
            if ($user) {
                $token = Str::random(255);
                $user->token = $token;
                $user->save();
                
                // Create Token
                $verificationLink = Modulate::signedLink('password.reset', [
                    'email' => $user->email,
                    'token' => $token
                ]);

                // Send Token
                Mail::to($user)->send(new SendPasswordReset($verificationLink, $user));
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'message' => 'The token to reset your password, has been sent to your email.',
        ], 200); 
    }

    /**
     ** Create new User Passwort
     **  > Check Password Requirements
     **  > Validate URL & Token
     **  > Update current Password (hashed)
     * @param Request $request
     * @return void
     */
    public function verifyToken(String $email, String $token, Request $request) 
    {
        try {
            
            $data = $request->validate([
                'password' => ['required', 'string', 'max:255', 'confirmed'],
            ]);

            // Validate Password
            $password = $data['password'];
            $verifyPassword = new Password;
            if(!$verifyPassword->verifyPassword($password)){
                throw new Exception($verifyPassword->error);
            }

            // Validate Signature
            if (!$request->hasValidSignature()) throw new Exception('Link has been expired.');
            $user = User::where([
                'email' => $email,
                'token' => $token
            ])->first();

            // Set User
            if(!$user) throw new Exception('Invalid verification key.');
            $user->password = Hash::make($password);
            $user->token = null;
            $user->save();

            // Login
            $token = $user->createToken('user')->accessToken;
            return response()->json([
                'token' => $token,
                'message' => 'Your password has been updated.'
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }

        return response()->json([
            'message' => 'Your password has been updated.'
        ], 200);
    }
}
