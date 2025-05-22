<?php

namespace App\Enums;

enum RoleType: string
{
    case SUPERADMIN = 'Super Admin';
    case ADMIN = 'Admin';
    case OPERATOR = 'Operator';
    case VIEWER = 'VIEWER';
}