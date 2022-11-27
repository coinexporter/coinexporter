<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignCategory extends Model
{
    protected $fillable = [
        'campaign_category_name',
        'campaign_category_status',
    ];
    
}
