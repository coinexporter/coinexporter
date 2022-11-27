<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfluenceMarketing extends Model
{
    use HasFactory;
    protected $table = 'influence_marketing';

    protected $fillable = [
        'name',
        'email',
        'social_platform',
        'social_link',
        'channel_name',
        'message',
        'status',
    ];
}
