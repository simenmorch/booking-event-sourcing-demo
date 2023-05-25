<?php

namespace App\Domains\Bookings\Projections;

use Spatie\EventSourcing\Projections\Projection;

class BookingProjection extends Projection
{
    protected $table = 'bookings';

    protected $guarded = ['id'];
}
