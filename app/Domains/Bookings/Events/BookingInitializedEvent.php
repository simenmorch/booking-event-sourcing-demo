<?php

namespace App\Domains\Bookings\Events;

use App\Domains\Bookings\Enums\BookingType;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class BookingInitializedEvent extends ShouldBeStored
{
    public function __construct(
        public string $bookingUuid,
        public string $customerEmail,
        public string $customerName,
        public ?string $customerPhone,
        public BookingType $type,
        public int $guests,
        public int $price,
    ) {
    }
}
