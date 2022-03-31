<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use Notifiable;
    use LogsActivity;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['status' => 'boolean'];
    protected $appends = ['customId'];

    // ACTIVITY LOGS
    protected static $logUnguarded = true;
    protected static $ignoreChangedAttributes = ['password', 'updated_at'];
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

        return "{$eventName} a {$new}user";
    }
    // ACTIVITY LOGS

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function getCustomIdAttribute()
    {
        return sprintf('PB%05d', $this->id);
    }

    public function userRedirection()
    {
        if (auth()->user()->role_id === 1) {
            return route('dashboard');
        }

        return route('page.management');
    }
}
