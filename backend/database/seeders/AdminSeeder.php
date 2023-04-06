<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Parent: User
     * Child: Admin
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('users') ->where('email', '=', 'admin@admin.com')->first();
        $userID = $user ? $user->id : null;
        if(!$userID) return;


        DB::table('admins')->insert([
            'user_id' => $userID,
            'role' =>'Owner',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
