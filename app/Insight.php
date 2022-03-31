<?php

namespace App;

use App\Traits\SlugTitle;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Insight extends Model implements Searchable
{
    use LogsActivity;
    use SlugTitle;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $casts = ['seo' => 'array'];
    protected $appends = ['bannerPath', 'thumbnailPath', 'publishedAtPicker'];

    // ACTIVITY LOGS
    protected static $logUnguarded = true;
    protected static $ignoreChangedAttributes = ['slug', 'updated_at'];
    protected static $logOnlyDirty = true;

    public static function boot()
    {
        parent::boot();

        Activity::saving(function (Activity $activity) {
            $activity->causer_ip = request()->ip();
        });
    }
    public function getBannerPathAttribute()
    {
        return "/storage/insights/{$this->slug}/{$this->banner}";
    }

    public function getThumbnailPathAttribute()
    {
        return "/storage/insights/{$this->slug}/thumbnail_{$this->banner}";
    }

    public function getPublishedAtAttribute($date)
    {
        return \Carbon\Carbon::parse($date)->format('M d, Y');
    }

    public function getPublishedAtPickerAttribute()
    {
        return \Carbon\Carbon::parse($this->published_at)->format('Y-m-d');
    }

    // searchables 🔎🔎🔎
    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->title,
            url("insight/{$this->slug}")
        );
    }
}
