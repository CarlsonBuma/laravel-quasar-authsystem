<?php

namespace App\Actions\Auth;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    /**
     ** Get User Data
     **     > User Credentials
     **     > ...
     *
     * @return void
     */
    public function authUser()
    {
        $user = Auth::user();
        $isAdmin = Auth::user()->is_admin;

        $avatarPath = $user->avatar
            ? asset(public_path('avatar') . '/' . $user->avatar)
            : '';
        
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'avatar' => $avatarPath,
            'email' => $user->email,
            'role' => 'owner',
            'is_admin' => $isAdmin ? true : false
        ], 200);
    }

    /**
     ** User Verification 
     **  > Attemps-Middleware: throttle:6,1
     **  > Handle Verified Email
     **  > Start Session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loginUser(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            // Check Credentials
            if (Auth::attempt([
                    'email' => $credentials['email'],
                    'password' => $credentials['password']
                ]
            )){
                // Login if verified
                if(Auth::user()->email_verified_at) {
                    $token = Auth::user()->createToken('Baerer_')->accessToken;
                    return response()->json([
                        'token' => $token,
                        'message' => 'Session started.'
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 'email_not_verified',
                        'email' => $credentials['email'],
                        'message' => 'Please verify your email before accessing your account.',
                    ], 401);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 401);
        }

        return response()->json([
            'message' => 'The provided credentials do not match our records.',
        ], 401);
    }

    /**
     ** Handle Logout.
     **  > Remove Session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logoutUser(Request $request)
    {
        try {
            // We want to delete Token instead of revoke
            Auth::user()->token()->delete();
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
        return response()->json([
            'message' => 'Session removed.'
        ], 200);
    }
}
