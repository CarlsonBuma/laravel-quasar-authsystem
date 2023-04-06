<?php

namespace App\Actions\Auth;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    private $emailVerified = false;

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
        $isAdmin = Auth::user()->is_admin->exists();
        $avatarPath = $user->avatar
            ? asset(public_path('avatar') . '/' . $user->avatar)
            : '';
        
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'avatar' => $avatarPath,
            'email' => $user->email,
            'role' => 'owner',
            'is_admin' => $isAdmin
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
                'remember' => ['required', 'boolean']
            ]);

            // Authorize User
            if (Auth::attempt([
                    'email' => $credentials['email'],
                    'password' => $credentials['password'],
                ], $credentials['remember']
            )){
                // Check if Email is verified
                if(Auth::user()->email_verified_at) {
                    $user = Auth::user();
                    $request->session()->regenerate();
                    return response()->json([
                        'message' => 'Hi ' . $user->name . ', you logged in successfully.',
                        'success' => true,
                        'email' => false
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
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
        return response()->json([
            'message' => 'Logged out. See you soon.'
        ], 200);
    }
}
