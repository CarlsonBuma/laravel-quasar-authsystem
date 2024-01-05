<?php

namespace App\Http\Controllers\Auth;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserAuthController extends Controller
{
    /**
     ** Get User Data
     **     > User Credentials
     *
     * @return void
     */
    public function authUser()
    {
        // User
        $user = Auth::user();
        $isAdmin = Auth::user()->is_admin;
        $avatarPath = $user->avatar
            ? URL::to(Storage::url('userAvatar')) . '/' . $user->avatar
            : '';
        
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'avatar' => $avatarPath,
            'email' => $user->email,
            'is_admin' => $isAdmin ? true : false,
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

            // Check if Email is verified
            $user = User::where('email', $credentials['email'])->first();
            if($user && !$user->email_verified_at instanceof Carbon) {
                return response()->json([
                    'status' => 'email_not_verified',
                    'email' => $credentials['email'],
                    'message' => 'Please verify your email before accessing your account.',
                ], 401);
            }

            // Check Credentials
            if (Auth::attempt([
                    'email' => $credentials['email'],
                    'password' => $credentials['password']
            ])){
                $token = Auth::user()->createToken('user')->accessToken;
                return response()->json([
                    'token' => $token,
                    'message' => 'Session started.'
                ], 200);
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
     ** Remove Session
     * @return void
     */
    public function logoutUser()
    {
        try {
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
