<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use LogsActivity;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'account'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // for activity logs --- all events 
    protected static $recordEvents =  ['created', 'updated', 'deleted'];

    // this is for fields about which things will be reported.
    protected static $logAttributes = ['name', 'email', 'password', 'account'];

    // for description 
    public function getDescriptionForEvent(string $eventName): string
    {
        return "The user has been {$eventName}";
    }

    // reporting only changed value
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected static $logName = 'User';
    

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function hasRented()
    {
        return $this->belongsToMany('App\Book')->withPivot(['past_charges', 'current_charge'])->withTimestamps();
    }
}
