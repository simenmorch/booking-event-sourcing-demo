<?php

namespace App\Domains\Bookings\Projections;

use Spatie\EventSourcing\Projections\Projection;

class InvoiceProjection extends Projection
{
    protected $table = 'invoices';

    protected $guarded = ['id'];
}
