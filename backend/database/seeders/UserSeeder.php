<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User
        $userTable = DB::table('users');
        $userTable->insert([
            'name' => 'Owner',
            'email' =>'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Admin
        DB::table('admins')->insert([
            'user_id' => $userTable->where('email', '=', 'admin@admin.com')->first()->id,
            'role' =>'Owner',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
