<?php

namespace App\Domains\Bookings\Projections;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\EventSourcing\Projections\Projection;

class BookingProjection extends Projection
{
    protected $table = 'bookings';

    protected $guarded = ['id'];

    public function currentInvoice(): HasOne
    {
        return $this->hasOne(InvoiceProjection::class, 'uuid', 'current_invoice_uuid');
    }
}
