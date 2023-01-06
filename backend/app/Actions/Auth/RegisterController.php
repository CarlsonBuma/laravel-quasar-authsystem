<?php

namespace App\Actions\Auth;

use Exception;
use App\Models\User;
use App\Globals\Password;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    private $errorType = 'email';

    /**
     ** Registration / Create Account
     **  > Creates new User
     **  > Verified: Null
     **  > Verification Request must be commited by user
     *
     * @param Request $request
     * @return void
     */
    public function register(Request $request)
    {
        try {

            $data = $request->validate([
                'name' => ['required', 'string', 'max:125'],
                'email' => ['required', 'string', 'email', 'unique:users', 'max:255'],
                'password' => ['required', 'string', 'max:255', 'confirmed'],
                'terms' => ['required', 'boolean'],
            ]);
    
            $name = $data['name'];
            $email = $data['email'];
            $password = $data['password'];
            $terms = $data['terms'];

            // Validate Terms
            if(!$terms) {
                $this->errorType = 'agreement';
                throw new Exception('Please accept our Terms & Policies.');
            }

            // Validate Password
            $verifyPassword = new Password;
            if(!$verifyPassword->verifyPassword($password)){
                $this->errorType = 'password';
                throw new Exception($verifyPassword->error);
            }

            // Create User
            User::create([
                'name' => $name,
                'email' => $email,
                'password' =>  Hash::make($password)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errorType' => $this->errorType
            ], 422);
        }
        
        return response()->json([
            'message' => 'Success! Your account has been created.',
            'email' => $email
        ], 200);
    }
}
