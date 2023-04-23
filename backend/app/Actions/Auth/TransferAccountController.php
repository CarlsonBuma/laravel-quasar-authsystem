<?php

namespace App\Actions\Auth;

use Exception;
use App\Models\User;
use App\Modules\Modulate;
use App\Modules\Password;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Mail\SendEmailVerification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class TransferAccountController extends Controller
{
    /**
     ** Transfer Account to new Emailadress
     **  > Before changing email, user has to verify his new email adress
     *
     * @param Request $request
     * @return void
     */
    public function transferAccountRequest(Request $request)
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
            
            // Send Token
            $this->sendAccountToken($user, $newEmail);
            $userAccount = User::where('id', Auth::id())->first();
            $userAccount->email_verified_at = null;
            $userAccount->save();

            // Logout
            $userLog = new UserAuthController;
            $userLog->logoutUser($request);

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
     *
     * @param User $user
     * @param String $newEmail
     * @return void
     */
    public function sendAccountToken(User $user, String $newEmail = '')
    {
        try {
            // Token for verification
            $token = Str::random(125);

            // Send verification Link
            $verificationLink = Modulate::signedLink('transfer.account', [
                'email' => $user->email,
                'token' => $token,
                'transfer' => $newEmail
            ]);

            Mail::to($newEmail)->send(new SendEmailVerification($verificationLink, $user));

            // Verification
            PasswordReset::updateOrCreate([
                'email' => $user->email
            ], [
                'token' => Hash::make($token),
                'created_at' => now()
            ]);

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
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
    public function transferAccount(String $email, String $token, String $transfer, Request $request)
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
            if(! ($email && $token && $transfer)) throw new Exception('No valid verification key.');
            if (!$request->hasValidSignature()) throw new Exception('Link has been expired.');

            // Verify Credentials
            $verifiedToken = PasswordReset::where('email', $email)->first();
            if(!$verifiedToken) throw new Exception('No valid verification key.');
            if (!Hash::check($token, $verifiedToken->token)) throw new Exception('No valid verification key.');

            // Check Email Unique
            if(User::where('email', $transfer)->exists()) throw new Exception('Ups, the new email is already taken.');
            $verifiedToken->delete();

            // Change email
            $user = User::where([
                'email' => $email,
            ])->first();

            
            if(!$user) throw new Exception('This user does not exist anymore.');
            if($user->email_verified_at) throw new Exception('This user is already verified.');

            $user->email = $transfer;
            $user->email_verified_at = now();
            $user->password = Hash::make($password);
            $user->remember_token = null;
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
