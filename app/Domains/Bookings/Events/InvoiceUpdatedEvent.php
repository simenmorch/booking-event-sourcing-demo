<?php

namespace App\Domains\Bookings\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class InvoiceUpdatedEvent extends ShouldBeStored
{
    public function __construct(
        public string $bookingUuid,
        public string $newInvoiceUuid,
        public string $currentInvoiceUuid,
        public int $newTotalPrice
    ) {
    }
}
