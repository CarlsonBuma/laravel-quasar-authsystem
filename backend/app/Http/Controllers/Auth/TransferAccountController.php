<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use App\Modules\Modulate;
use App\Modules\Password;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SendEmailVerification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class TransferAccountController extends Controller
{
    /**
     ** Transfer Account to new Emailadress
     **  > Before changing email, new user has to verify his new email adress
     **  > Old user is still able to undone its transfer, by verifying its old email again
     * @param Request $request
     * @return void
     */
    public function sendToken(Request $request)
    {
        try {
            $data = $request->validate([
                'email' => ['required', 'string', 'email', 'unique:users', 'max:255'],  // Unique Email
                'password' => ['required', 'string', 'max:255'],
            ]);
            
            $newEmail = $data['email'];
            $password = $data['password'];
            $user = Auth::user();
            if(!Hash::check($password, $user->password)) throw new Exception('Ups, the given password is incorrect.');
            
            // Process Transfer
            $token = Str::random(255);
            $this->sendAccountToken($user, $newEmail, $token);
            $userAccount = User::where('id', Auth::id())->first();
            $userAccount->email_verified_at = null;
            $userAccount->token = $token;
            $userAccount->save();

            // Remove Token
            $user->token()->delete();
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'message' => 'Transfering user in progress...',
        ], 200);
    }

    /**
     * ** Request Transfer Email
     **  > Generate URL, with Token 
     **  > Send verification link to new email
     * @param User $user
     * @param String $newEmail
     * @return void
     */
    private function sendAccountToken(User $user, String $newEmail = '', $token)
    {
        // Send verification Link
        $verificationLink = Modulate::signedLink('transfer.account', [
            'email' => $user->email,
            'token' => $token,
            'transfer' => $newEmail
        ]);

        Mail::to($newEmail)->send(new SendEmailVerification($verificationLink, $user)); 
    }

    /**
     ** Verify Email transfer
     **  > Validate URL & Token
     **  > New Email must be unique
     **  > Change email & update email_verified_at
     *
     * @param String $email
     * @param String $token
     * @param String $transfer (New Email)
     * @param Request $request
     * @return void
     */
    public function verifyToken(String $email, String $token, String $transfer, Request $request)
    {
        try {

            $data = $request->validate([
                'password' => ['required', 'string', 'max:255', 'confirmed'],
                'terms' => ['required', 'boolean'],
            ]);

            // Validate
            if(!$data['terms']) throw new Exception('Please agree with our Terms & Conditions.');
            $password = $data['password'];
            $verifyPassword = new Password;
            if(!$verifyPassword->verifyPassword($password)){
                throw new Exception($verifyPassword->error);
            }

            // Validate Signature
            if (!$request->hasValidSignature()) throw new Exception('Link has been expired.');
            $user = User::where([
                'email' => $email,
                'email_verified_at' => null,
                'token' => $token
            ])->first();

            // Set User
            if(!$user) throw new Exception('Invalid verification key.');
            $user->email = $transfer;
            $user->password = Hash::make($password);
            $user->email_verified_at = now();
            $user->token = null;
            $user->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'message' => 'Your account has been transfered! Please login with your new email.',
        ], 200);
    }
}
