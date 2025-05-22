<?php

namespace App\Enums;

enum RecurringType: string
{
    case ORTU = 'Orang Tua/Wali Peserta Magang';
    case VENDOR = 'Vendor/Supplier Rutin';
    case MITRA = 'Mitra Bisnis';
    case KONTRAKTOR = 'Kontraktor';
    case LAINNYA = 'Lainnya';
}