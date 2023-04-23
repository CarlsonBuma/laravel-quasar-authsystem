<?php

namespace App\Actions\Auth;

use Exception;
use App\Models\User;
use App\Modules\Modulate;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Exceptions\customException;
use App\Mail\SendEmailVerification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class EmailVerificationController extends Controller
{
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
            
            // Send Link to User
            if ($user && !$user->email_verified_at) {
                $hash = sha1($user->email);
                $verificationLink = Modulate::signedLink('email.verification', [
                    'email' => $user->email,
                    'token' => $hash
                ]);
                Mail::to($user)->send(new SendEmailVerification($verificationLink, $user));
            }
        } catch (Exception $e) {
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
    public function emailVerification(String $email, String $token, Request $request)
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

            // Validation
            if(!$user) throw new Exception('No valid verification key.');
            else if(!$user->email) throw new Exception('No valid verification key.');
            else if(sha1($user->email) !== $token) throw new Exception('No valid verification key.');
            else if ($user->email_verified_at) throw new Exception('Email is already verified.');
            
            // Verify
            if(!$user->email_verified_at) {
                $user->email_verified_at = now();
                $user->save();

                // Reset Password - Reset - Request
                // As it could be set in other Actions - eg. TransferAccount
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
