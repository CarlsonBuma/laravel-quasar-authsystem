<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use App\Modules\Modulate;
use App\Modules\Password;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exceptions\customException;
use App\Mail\SendEmailVerification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
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
    public function sendToken(Request $request)
    {
        try {
            $data = $request->validate([
                'email' => ['required', 'string', 'email', 'max:255'],
            ]);


            $user = User::where('email', $data['email'])->first();
            if ($user && !$user->email_verified_at) {
                DB::beginTransaction();
                    
                    // Save token
                    $token = Str::random(255);
                    $user->token = $token;
                    $user->save();

                    // Create Link
                    $verificationToken = Modulate::signedLink('email.verification', [
                        'email' => $user->email,
                        'token' => $token
                    ]);

                    // Send email
                    Mail::to($user)->send(new SendEmailVerification($verificationToken, $user));
                DB::commit(); 
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        } catch(customException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 200);
        }

        return response()->json([
            'message' => 'Token has been sent to your email.',
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
    public function verifyToken(String $email, String $token, Request $request)
    {      
        try {
            $data = $request->validate([
                'password' => ['required', 'string', 'max:255', 'confirmed'],
            ]);

            // Validate Password
            $password = $data['password'];
            $verifyPassword = new Password;
            if(!$verifyPassword->verifyPassword($password)) throw new Exception($verifyPassword->error);

            // Check link signature
            if (!$request->hasValidSignature()) throw new Exception('Link has been expired.');

            // Validate Token
            $user = User::where([
                'email' => $email,
                'email_verified_at' => null,
                'token' => $token
            ])->first();
            
            // Set User
            if(!$user) throw new Exception('Invalid verification key.');
            $user->password = Hash::make($password);
            $user->email_verified_at = now();
            $user->token = null;
            $user->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }

        // Login
        $token = $user->createToken('user')->accessToken;
        return response()->json([
            'token' => $token,
            'message' => 'Welcome! You your email has been verified.'
        ], 200);
    }
}
