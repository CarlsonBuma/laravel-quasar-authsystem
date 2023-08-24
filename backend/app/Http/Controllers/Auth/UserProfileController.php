<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use App\Modules\Password;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class UserProfileController extends Controller
{
    /**
     ** Change Avatar
     **  > Update Avatar
     **      > Delete Old Avatar
     **      > Add new Avatar
     **      > Link new Avatar with DB
     **  > Delete Avatar
     **      > Delete Old Avatar 
     *
     * @param Request $request
     * @return void
     */
    public function changeAvatar(Request $request) {
        try {

            $data = $request->validate([
                'avatar' => ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'],
                'delete' => ['required', 'boolean'],
            ]);

            // User's Avatar
            $userID = Auth::id();
            $currentUser = User::find($userID);
            $userAvatar = $currentUser->avatar;

            // Delete Avatar
            if($data['delete']) {
                if($userAvatar) {
                    Storage::disk('avatar')->delete($userAvatar);
                    $currentUser->avatar = null;
                    $currentUser->save();
                }
            }

            // Update Image
            else {
                if(isset($data['avatar'])) {
                    
                    // Module Image
                    $fileExtension = $request->file('avatar')->extension();
                    $imageName = $userID . '-' . Str::random(32) . '.' . $fileExtension;
                
                    // Change Image: Existing vs. non existing
                    if($userAvatar) Storage::disk('avatar')->delete($userAvatar);       
                    Storage::putFileAs('avatars', $request->file('avatar'), $imageName);
                    
                    // Save in DB
                    $currentUser->avatar = $imageName;
                    $currentUser->save();
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'message' => 'Success! Your avatar has been changed.',
        ], 200);
    }

    /**
     ** Change Username
     *
     * @param Request $request
     * @return void
     */
    public function changeName(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
            ]);
    
            $userID = Auth::id();
            $name = $data['name'];
            $user = User::find($userID);
            $user->update([
                'name' => $name,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'message' => 'Success! Your username has been changed.',
        ], 200);
    }

    /**
     ** Update Password
     **  > Check Password requirements
     **  > Confirm old Password
     *
     * @param Request $request
     * @return void
     */
    public function changePassword(Request $request)
    {
        try {

            $data = $request->validate([
                'password_current' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'max:255', 'confirmed'],
            ]);
    
            $userID = Auth::id();
            $passwordConfirm = $data['password_current'];
            $passwordNew = $data['password'];

            // Validate Password
            $verifyPassword = new Password;
            if(!$verifyPassword->verifyPassword($passwordNew)) throw new Exception($verifyPassword->error);
            
            // Check Current Password
            $user = User::find($userID);
            if(!Hash::check($passwordConfirm, $user->password)) throw new Exception('Ups, the given password is incorrect.');
            
            // Update Password
            $user->update([
                'password' => Hash::make($passwordNew)
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'message' => 'Success! Your password has been changed.',
        ], 200);
    }

    /**
     ** Delete User Account
     **  > Remove Avatar
     **  > Logout User
     *
     * @param Request $request
     * @return void
     */
    public function deleteAccount(Request $request)
    {
        try {

            $data = $request->validate([
                'password' => ['required', 'string', 'max:255'],
            ]);
    
            $userID = Auth::id();
            $password = $data['password'];

            // Check Current Password
            $user = User::find($userID);
            if(!Hash::check($password, $user->password)) throw new Exception('Ups, the given password is incorrect.');
            
            // Remove Avatar
            $userAvatar = $user->avatar;
            if($userAvatar) {
                Storage::disk('avatar')->delete($userAvatar);
            }

            // Delete Userdata
            // Oauth CASCADE
            $user->delete();
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'message' => 'Your account has been removed.',
        ], 200);
    }
}
