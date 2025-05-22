<?php

namespace App\Enums;

enum VisitorType: string
{
    case UMUM = 'Tamu Umum';
    case MAGANG = 'Magang';
    case TAMU_BERULANG = 'Tamu Berulang';
}
