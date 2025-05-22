<?php

namespace App\Enums;

enum RelationType: string
{
    case ORTU = 'Orang Tua';
    case VENDOR = 'Vendor';
    case MITRA = 'Mitra';
    case KONTRAKTOR = 'Kontraktor';
    case LAINNYA = 'Lainnya';
}