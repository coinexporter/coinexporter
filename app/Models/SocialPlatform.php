<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialPlatform extends Model
{
   protected $table = 'social_platform';

   protected $fillable = [
      'social_link_id',
      'social_platform_name',
      'status'
  ];
}
