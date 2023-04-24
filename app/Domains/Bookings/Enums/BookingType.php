<?php

namespace App\Domains\Bookings\Enums;

enum BookingType: string
{
    case PRIVATE_EVENT = 'private_event';
    case JOINED_TRIP = 'joined_trip';
    case PACKAGE_TRIP = 'package_trip';
}
