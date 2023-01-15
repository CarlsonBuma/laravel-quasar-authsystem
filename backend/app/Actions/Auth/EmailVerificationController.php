<?php

namespace App\Actions\Auth;

use Exception;
use App\Models\User;
use App\Modules\Modulate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Exceptions\customException;
use App\Mail\SendEmailVerification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class EmailVerificationController extends Controller
{
    /**
     * ** Request Transfer Email
     **  > Generate URL, with Token 
     **  > Send verification link to new email
     *
     * @param User $user
     * @param String $newEmail
     * @return void
     */
    public function emailTransferRequest(User $user, String $newEmail)
    {
        try {
            // Token for verification
            $token = Str::random(55);

            // Send verification Link
            $verificationLink = Modulate::signedLink('user.transfer.verification', [
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
     * @param String $transfer
     * @param Request $request
     * @return void
     */
    public function accountTransfer(String $email, String $token, String $transfer, Request $request)
    {
        try {

            // Validate Signature
            if(! ($email && $token && $transfer)) throw new Exception('No valid verification key.');
            if (!$request->hasValidSignature()) throw new Exception('Link has been expired.');
            
            // Verify Credentials
            $verifiedToken = PasswordReset::where('email', $email)->first();
            if(!$verifiedToken) throw new Exception('No valid verification key.');
            if (!Hash::check($token, $verifiedToken->token)) throw new Exception('No valid verification key.');
            if(User::where('email', $transfer)->exists()) throw new Exception('Ups, the new email is already taken.');
            $verifiedToken->delete();

            // Change email
            $user = User::where([
                'email' => $email
            ])->first();

            
            if(!$user) throw new Exception('This user does not exist anymore.');
            if($user->email_verified_at) throw new Exception('This user is verified.');

            $user->email = $transfer;
            $user->email_verified_at = now();
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

    /**
     ** Request email verificaton
     ** > Generate URL, with Token 
     ** > Send verification link
     *
     * @param Request $request
     * @return void
     */
    public function emailVerificationRequest(Request $request)
    {
        try {
            $data = $request->validate([
                'email' => ['required', 'string', 'email', 'max:255'],
            ]);

            $user = User::where([
                'email' => $data['email'],
            ])->first();
            
            // Send mail
            if ($user && !$user->email_verified_at) $this->sendVerificationMail($user);

        } catch (Exception $e) {
            // Errors
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        } catch(customException $e) {
            // Email is already verified.
            return response()->json([
                'message' => $e->getMessage(),
            ], 200);
        }

        return response()->json([
            'message' => 'Verification link has been sent to your email.',
        ], 200);
    }

    public function sendVerificationMail(Object $user)
    {
        try {
            $hash = sha1($user->email);
            $verificationLink = Modulate::signedLink('email.verification', [
                'email' => $user->email,
                'token' => $hash
            ]);
            Mail::to($user)->send(new SendEmailVerification($verificationLink, $user));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     ** Verify Email
     **  > Validate URL & Token
     **  > Change email & update email_verified_at
     *
     * @param String $id
     * @param String $hash
     * @param Request $request
     * @return void
     */
    public function confirmEmailLink(String $email, String $token, Request $request)
    {      
        try {
            // Validate Signature
            if (!$request->hasValidSignature()) {
                throw new Exception('Link has been expired.');
            }

            // Validate user
            $user = User::where([
                'email' => $email,
            ])->first();

            if(!$user) throw new Exception('No valid verification key.');
            else if(!$user->email) throw new Exception('No valid verification key.');
            else if(sha1($user->email) !== $token) throw new Exception('No valid verification key.');
            else if ($user->email_verified_at) throw new Exception('Email is already verified.');
            
            if(!$user->email_verified_at) {
                // Verify
                $user->email_verified_at = now();
                $user->save();

                // Reset Password - Reset - Request
                // As it could be set in other Actions
                $passwordRequest = PasswordReset::where('email', $user->email)->first();
                if($passwordRequest) $passwordRequest->delete();
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'message' => 'Email has been validated successfully.',
        ], 200);
    }
}
