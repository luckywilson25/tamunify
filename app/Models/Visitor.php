<?php

namespace App\Models;

use App\Enums\VisitorType;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'identity_number',
        'phone',
        'email',
        'photo',
        'type',
        'status'
    ];

    protected $casts = [
        'type' => VisitorType::class
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function general()
    {
        return $this->hasOne(VisitorGeneral::class, 'visitor_id');
    }

    public function internship()
    {
        return $this->hasOne(VisitorInternship::class, 'visitor_id');
    }

    public function recurring()
    {
        return $this->hasOne(VisitorRecurring::class, 'visitor_id');
    }

    public function reaction()
    {
        return $this->hasOne(Reaction::class, 'visitor_id');
    }
}