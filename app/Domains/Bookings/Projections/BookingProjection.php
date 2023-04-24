<?php

namespace App\Domains\Bookings\Projections;

use App\Domains\Bookings\Enums\BookingType;
use Spatie\EventSourcing\Projections\Projection;

class BookingProjection extends Projection
{
    protected $table = 'bookings';

    protected $guarded = ['id'];

    protected $casts = [
        'type' => BookingType::class,
    ];
}
