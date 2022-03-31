<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'modules', 'description',
    ];

    protected $casts = [
        'modules' => 'array',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = str_replace(' ', '-', $value);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = ucwords($value);
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
}
