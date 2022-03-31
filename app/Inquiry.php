<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
