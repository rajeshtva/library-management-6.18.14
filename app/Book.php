<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Book extends Model
{
    use LogsActivity;
    protected $guarded = [];

    // this is for fields about which things will be reported.
    protected static $logAttributes = ['book_name', 'author_name', 'description', 'price'];

    //for add events 
    protected static $recordEvents =  ['created', 'updated', 'deleted'];

    // for description 
    public function getDescriptionForEvent(string $eventName): string
    {
        return "The user has been {$eventName}";
    }

    // reporting only changed value
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected static $logName = 'User';

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rentedBy()
    {
        return $this->belongsToMany('App\User')->withPivot(['past_charges', 'current_charge'])->withTimestamps();
    }
}
