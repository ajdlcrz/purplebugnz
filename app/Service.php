<?php

namespace App;

use App\Traits\SlugTitle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Service extends Model implements Searchable
{
    use LogsActivity;
    use SlugTitle;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'offers' => 'array',
        'seo' => 'array',
    ];

    protected $appends = ['bannerPath', 'thumbnailPath', 'strippedDescription'];

    // ACTIVITY LOGS
    protected static $logUnguarded = true;
    protected static $ignoreChangedAttributes = ['updated_at'];
    protected static $logOnlyDirty = true;

    public static function boot()
    {
        parent::boot();

        Activity::saving(function (Activity $activity) {
            $activity->causer_ip = request()->ip();
        });
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        $new = $eventName == 'created' ? 'new ' : '';

        return "{$eventName} a {$new}service";
    }
    // ACTIVITY LOGS end

    public function getBannerPathAttribute()
    {
        return "/storage/services/{$this->slug}/{$this->banner}";
    }

    public function getThumbnailPathAttribute()
    {
        return "/storage/services/{$this->slug}/thumbnail_{$this->banner}";
    }

    public function getStrippedDescriptionAttribute()
    {
        return Str::limit(strip_tags($this->description), 150);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    // searchables 🔎🔎🔎
    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->title,
            url("service/{$this->slug}")
        );
    }
}
