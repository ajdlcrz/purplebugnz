<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait SlugTitle
{
    protected static function bootSlugTitle()
    {
        static::created(function ($model) {
            $model->update(['slug' => $model->title]);
        });

        static::updating(function ($model) {
            $model->slug =  Str::slug($model->title);
        });
    }

    protected function setSlugAttribute($value)
    {
        if (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this))) {
            if (static::withTrashed()->where('id', '!=', $this->id)->whereSlug($slug = Str::slug($value))->exists()) {
                $slug = "{$slug}-{$this->id}";
            }
        } else {
            if (static::where('id', '!=', $this->id)->whereSlug($slug = Str::slug($value))->exists()) {
                $slug = "{$slug}-{$this->id}";
            }
        }

        $this->attributes['slug'] = $slug;
    }
}
