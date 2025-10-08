<?php

namespace App\Traits;

use Spatie\Activitylog\Traits\LogsActivity;

trait BaseActivityLoggable
{
    use LogsActivity;

    protected static $logAttributes = ['*']; // change all attribute log
    protected static $logOnlyDirty = true;   //  only changed attribute
    protected static $submitEmptyLogs = false; // if no changes, no log

    /**
     * generate description for every event
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        $modelName = class_basename($this);
        return "Admin has {$eventName} a {$modelName}";
    }
}
