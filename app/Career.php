<?php

namespace App;

use App\Traits\SlugTitle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Career extends Model implements Searchable
{
    use LogsActivity;
    use SlugTitle;
    use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $casts = [
        'seo' => 'array',
        'status' => 'boolean'
    ];
    protected $appends = ['bannerPath'];

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

        return "{$eventName} a {$new}career";
    }
    // ACTIVITY LOGS end

    // searchables 🔎🔎🔎
    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->title,
            url("/career/{$this->slug}")
        );
    }

    // Accessors
    public function getBannerPathAttribute()
    {
        return "/storage/careers/{$this->slug}/{$this->banner}";
    }
}
