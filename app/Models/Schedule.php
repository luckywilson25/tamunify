<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'user_id',
        'date_start',
        'date_end',
        'time_start',
        'time_end',
        'status',
        'location',
        'participant',
    ];

    protected $with = ['user'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}