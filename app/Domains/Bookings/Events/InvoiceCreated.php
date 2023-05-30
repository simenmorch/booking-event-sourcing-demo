<?php

namespace App\Domains\Bookings\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class InvoiceCreated extends ShouldBeStored
{
    public function __construct(
        public string $bookingUuid,
        public string $invoiceUuid,
        public string $totalPrice,
    ) {
    }
}
