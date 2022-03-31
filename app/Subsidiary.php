<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Subsidiary extends Model implements Searchable
{
    use LogsActivity;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends = ['imagePath'];

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

        return "{$eventName} a {$new}subsidiary";
    }
    // ACTIVITY LOGS end

    public function getImagePathAttribute()
    {
        return "/storage/about/subsidiaries/{$this->image}";
    }

    // searchables 🔎🔎🔎
    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->title,
            $this->link
        );
    }
}
