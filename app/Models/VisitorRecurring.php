<?php

namespace App\Models;

use App\Enums\RelationType;
use App\Enums\RecurringType;
use App\Enums\DepartmentType;
use Illuminate\Database\Eloquent\Model;

class VisitorRecurring extends Model
{
    protected $fillable = [
        'visitor_id',
        'company',
        'recurring_type',
        'recurring_type_more',
        'related_to',
        'relation',
        'relation_more',
        'department',
        'department_more',
        'access_start',
        'access_end',
        'vehicle_number',
        'visit_days',
        'usual_entry_time',
        'usual_exit_time',
        'additional_info',
    ];

    protected $with = ['visitor'];

    protected $casts = [
        'visit_days' => 'array',
        'access_start' => 'date',
        'access_end' => 'date',
        'recurring_type' => RecurringType::class,
        'relation' => RelationType::class,
        'department' => DepartmentType::class,
    ];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class, 'visitor_id');
    }
}