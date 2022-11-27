<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use HasFactory;
    protected $table = 'tbl_user_sociallinks';

    protected $fillable = [
        'user_id',
        'channel_id',
        'channel_name',
        'status'
    ];
}
