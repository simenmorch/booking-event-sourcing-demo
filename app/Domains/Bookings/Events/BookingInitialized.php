<?php

namespace App\Domains\Bookings\Events;

use App\Domains\Bookings\Enums\BookingType;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class BookingInitialized extends ShouldBeStored
{
    public function __construct(
        public string $customerEmail,
        public string $customerName,
        public ?string $customerPhone,
        public BookingType $type,
    ) {
    }
}
