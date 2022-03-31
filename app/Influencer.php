<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Influencer extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $casts = [
        'content_category' => 'array',
        'facebook' => 'array',
        'instagram' => 'array',
        'youtube' => 'array',
        'tiktok' => 'array',
    ];
}
