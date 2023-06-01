<?php

namespace App\Domains\Bookings\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class BookingCreatedEvent extends ShouldBeStored
{
    public function __construct(
        public string $bookingUuid,
        public string $customerEmail,
        public string $customerName,
        public ?string $customerPhone,
        public string $type,
    ) {
    }
}
