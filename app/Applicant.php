<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Applicant extends Model
{
    use LogsActivity;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $appends = ['applied_at'];

    // ACTIVITY LOGS
    protected static $logUnguarded = true;
    protected static $ignoreChangedAttributes = ['updated_at'];
    protected static $logOnlyDirty = true;
    protected static $recordEvents = ['updated'];

    public static function boot()
    {
        parent::boot();

        Activity::saving(function (Activity $activity) {
            $activity->causer_ip = request()->ip();
        });
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "{$eventName} an applicant";
    }
    // ACTIVITY LOGS end

    public function career()
    {
        return $this->belongsTo(Career::class)->withTrashed();
    }

    // Accessors
    public function getAppliedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->created_at)->format('Y-m-d');
    }
}
