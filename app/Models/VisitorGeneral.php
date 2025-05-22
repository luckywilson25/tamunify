<?php

namespace App\Models;

use App\Enums\PurposeType;
use App\Enums\DepartmentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisitorGeneral extends Model
{
    use HasFactory;

    protected $fillable = [
        'visitor_id',
        'company',
        'purpose',
        'purpose_more',
        'person_to_meet',
        'department',
        'department_more',
        'visit_date',
        'exit_date',
        'visit_time',
        'exit_time',
        'vehicle_number',
        'additional_info',
    ];

    protected $with = ['visitor'];
    protected $casts = [
        'visit_date' => 'date',
        'exit_date' => 'date',
        'purpose' => PurposeType::class,
        'department' => DepartmentType::class,
    ];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class, 'visitor_id');
    }
}