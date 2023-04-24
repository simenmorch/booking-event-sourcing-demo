<?php

namespace App\Domains\Bookings;

use App\Domains\Bookings\Enums\BookingType;
use App\Domains\Bookings\Events\BookingInitialized;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class BookingAggregateRoot extends AggregateRoot
{
    public function initialize(
        string $customerEmail,
        string $customerName,
        ?string $customerPhone,
        BookingType $type,
    ) {
        $this->recordThat(new BookingInitialized(
            customerEmail: $customerEmail,
            customerName: $customerName,
            customerPhone: $customerPhone,
            type: $type
        ));

        return $this;
    }
}
