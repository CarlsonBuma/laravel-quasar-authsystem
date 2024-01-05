<?php

namespace App\Models;

use App\Models\Admin;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'public.users';

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'avatar',
        'password',
        'token'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_is_verified() {
        return $this->email_verified_at ? true : false;
    }

    public function is_admin() {
        return $this->hasOne(Admin::class, 'user_id');
    }
}
