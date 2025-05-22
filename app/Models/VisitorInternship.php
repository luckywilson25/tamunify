<?php

namespace App\Models;

use App\Enums\ContactType;
use App\Enums\DepartmentType;
use Illuminate\Database\Eloquent\Model;

class VisitorInternship extends Model
{
    protected $fillable = [
        'visitor_id',
        'institution',
        'internship_start',
        'internship_end',
        'department',
        'department_more',
        'supervisor',
        'referral_letter',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relation',
        'emergency_contact_relation_more',
        'additional_info',
    ];

    protected $with = ['visitor'];

    protected $casts = [
        'internship_start' => 'date',
        'internship_end' => 'date',
        'department' => DepartmentType::class,
        'emergency_contact_relation' => ContactType::class
    ];


    public function visitor()
    {
        return $this->belongsTo(Visitor::class, 'visitor_id');
    }
}