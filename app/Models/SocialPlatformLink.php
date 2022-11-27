<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialPlatformLink extends Model
{
    use HasFactory;
    protected $table = 'social_platformlinks';

    protected $fillable = [
        'name',
        'status'
    ];
}
