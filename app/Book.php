<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];

    // protected $fillable = [
    //     'book_name', 'author_name', 'description', 'price', 'added_by'
    // ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rentedBy()
    {
        return $this->belongsToMany('App\User')->withPivot(['past_charges', 'current_charge'])->withTimestamps();
    }
}
