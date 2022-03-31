<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Testimonial extends Model
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

        return "{$eventName} a {$new}testimonial";
    }
    // ACTIVITY LOGS

    public function getImagePathAttribute()
    {
        return "/storage/services/{$this->service->slug}/testimonials/{$this->image}";
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
