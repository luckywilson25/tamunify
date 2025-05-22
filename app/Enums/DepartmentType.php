<?php

namespace App\Enums;

enum DepartmentType: string
{
    case PRODUKSI = 'Produksi';
    case ENGINEERING = 'Engineering';
    case HRD = 'HRD';
    case KEUANGAN = 'Keuangan';
    case MARKETING = 'Marketing';
    case IT = 'IT';
    case LAINNYA = 'Lainnya';
}