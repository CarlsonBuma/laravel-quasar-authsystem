<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppReleases extends Model
{
    use HasFactory;

    protected $table = 'public.app_releases';

    protected $fillable = [
        'title',
        'version',
        'description',
        'type'
    ];

    protected $casts = [
        'updated_at' => 'date:Y-m-d',
        'created_at' => 'date:Y-m-d',
    ];
}
