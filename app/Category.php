<?php

namespace App;

use App\Traits\SlugTitle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Model
{
    use LogsActivity;
    use SlugTitle;
    use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

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

    public function getDescriptionForEvent(string $eventName): string
    {
        $new = $eventName == 'created' ? 'new ' : '';

        return "{$eventName} a {$new}category";
    }
    // ACTIVITY LOGS

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
