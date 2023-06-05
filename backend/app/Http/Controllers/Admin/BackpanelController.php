<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;

class BackpanelController extends Controller
{
    /**
     ** Get User Data
     **     > User Credentials
     **     > ...
     *
     * @return void
     */
    public function getInfos()
    {
        $amountUser = User::where('email_verified_at', '!=', null)->count();
        return response()->json([
            'users' => $amountUser
        ], 200);
    }
}
