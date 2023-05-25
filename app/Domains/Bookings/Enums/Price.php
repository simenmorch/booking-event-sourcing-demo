<?php

namespace App\Domains\Bookings\Enums;

enum Price: int
{
    case PRIVATE_EVENT = 50;
    case JOINED_TRIP = 60;
    case PACKAGE_TRIP = 40;

    public static function fromName(string $name): Price
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }
        throw new \Exception('Booking type not found');
    }
}
