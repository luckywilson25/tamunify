<?php

namespace App\Enums;

enum ContactType: string
{
    case ORTU = 'Orang Tua';
    case SAHABAT = 'Sahabat';
    case KERABAT = 'Kerabat';
    case PASANGAN = 'Pasangan';
    case LAINNYA = 'Lainnya';
}