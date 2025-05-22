<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
     protected $fillable = [
        'visitor_id',
        'name',
        'note',
    ];

    protected $with = ['visitor'];


    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }
}
