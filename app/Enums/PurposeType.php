<?php

namespace App\Enums;

enum PurposeType: string
{
    case MEETING = 'Rapat / Meeting';
    case DELIVERY = 'Pengiriman / Delivery';
    case MAINTENANCE = 'Maintenance';
    case INTERVIEW = 'Interview';
    case LAINNYA = 'Lainnya';
}