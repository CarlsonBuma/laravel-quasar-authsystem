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

        $avatarPath = $user->avatar
            ? asset(public_path('avatar') . '/' . $user->avatar)
            : '';
        
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'avatar' => $avatarPath,
            'email' => $user->email,
            'role' => 'owner'
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

            // Check Credentials
            if (Auth::attempt([
                'email' => $credentials['email'],
                'password' => $credentials['password'],

                // CHeck if user is Verified
                // if user does not exists, email does not exists
                fn ($query) => $this->emailVerified = $query && $query->first() 
                    ? $query->first()->user_is_verified() 
                    : true,
            ], $credentials['remember'])) 
            {
                // Success
                if($this->emailVerified) {
                    $user = Auth::user();
                    $request->session()->regenerate();
                    return response()->json([
                        'message' => 'Hi ' . $user->name . ', you logged in successfully.',
                        'success' => true,
                        'email' => false
                    ], 200);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
                'email' => false
            ], 403);
        }

        // Response for not verified Mail
        if(!$this->emailVerified) {
            return response()->json([
                'message' => 'Please verify your email before accessing your account.',
                'success' => false,
                'email' => true
            ], 403);
        }
        
        // Default Answer
        return response()->json([
            'message' => 'The provided credentials do not match our records.',
            'success' => false,
            'email' => false
        ], 403);
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
            'message' => 'Logged out successfully. See you soon.'
        ], 200);
    }
}
