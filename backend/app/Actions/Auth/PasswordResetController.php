<?php

namespace App\Actions\Auth;

use Exception;
use App\Models\User;
use App\Globals\Modulate;
use App\Globals\Password;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
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
     *
     * @param Request $request
     * @return void
     */
    public function sendPasswordResetLink(Request $request)
    {
        try {

            $data = $request->validate([
                'email' => ['required', 'email'],
            ]);

            // Create Reset Token
            $user = User::where('email', $data['email'])->first();
            if ($user) {
                $token = Str::random(55);
                PasswordReset::updateOrCreate([
                    'email' => $user->email
                ], [
                    'token' => Hash::make($token),
                    'created_at' => now()
                ]);
                
                // Send verification Link
                $verificationLink = Modulate::signedLink('password.reset', [
                    'email' => $user->email,
                    'token' => $token
                ]);
                Mail::to($user)->send(new SendPasswordReset($verificationLink, $user));
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'message' => 'The link to reset your password has been sent.',
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
    public function resetPassword(String $email, String $hash, Request $request) 
    {
        try {
            
            $data = $request->validate([
                'password' => ['required', 'string', 'max:255', 'confirmed'],
            ]);
            
            $password = $data['password'];

            // Validate Password
            $verifyPassword = new Password;
            if(!$verifyPassword->verifyPassword($password)){
                throw new Exception($verifyPassword->error);
            }

            // Validate Signature
            if (!$request->hasValidSignatureWhileIgnoring(['password', 'password_confirmation'])) throw new Exception('Link has been expired.');
            
            // Verify Credentials
            $passwordResetQuery = PasswordReset::where('email', $email);
            $passwordResetEntry = $passwordResetQuery->first();
            if(!$passwordResetEntry) throw new Exception('No valid verification key.');
            if (!Hash::check($hash, $passwordResetEntry->token)) throw new Exception('No valid verification key.');
            
            // Verify User
            $user = User::where([
                'email' => $passwordResetEntry->email
            ])->first();
            if(!$user) throw new Exception('This user does not exist anymore.');
                
            // Create new Password & Verify Email as well
            $user->password = Hash::make($password);
            if(!$user->email_verified_at) $user->email_verified_at = now();
            $user->save();
                
            // Remove PasswordReset Entry
            $passwordResetQuery->delete();

        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }

        return response()->json([
            'message' => 'New password has been created!'
        ], 200);
    }
}
