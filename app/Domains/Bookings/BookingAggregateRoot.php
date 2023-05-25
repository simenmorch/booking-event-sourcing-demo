<?php

namespace App\Domains\Bookings;

use App\Domains\Bookings\Commands\InitializeBookingCmd;
use App\Domains\Bookings\Events\BookingInitializedEvent;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class BookingAggregateRoot extends AggregateRoot
{
    public function initialize(InitializeBookingCmd $command): self
    {
        $this->recordThat(new BookingInitializedEvent(
            bookingUuid: $this->uuid(),
            customerEmail: $command->getUserEmail(),
            customerName: $command->getUserName(),
            customerPhone: $command->getUserPhone(),
            type: $command->getType(),
            guests: $command->getGuests(),
            pricePerGuest: $command->getPricePerGuest(),
        ));

        return $this;
    }
}
