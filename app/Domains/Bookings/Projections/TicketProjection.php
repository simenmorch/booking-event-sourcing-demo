<?php

namespace App\Domains\Bookings\Projections;

use Spatie\EventSourcing\Projections\Projection;

class TicketProjection extends Projection
{
    protected $table = 'tickets';

    protected $guarded = ['id'];
}
