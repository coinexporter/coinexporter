<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportedCampaign extends Model
{
    use HasFactory;
  
    protected $fillable = [
        'id',
        'promoter_id',
        'employer_id',
        'campaign_id'
    ];
}
