<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'public.admins';

    protected $fillable = [
        'user_id',
        'role',
    ];

    public function belongs_to_user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
