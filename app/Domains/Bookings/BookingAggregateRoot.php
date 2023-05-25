<?php

namespace App\Domains\Bookings;

use App\Domains\Bookings\Commands\AddTicketsCmd;
use App\Domains\Bookings\Commands\CreateBookingCmd;
use App\Domains\Bookings\Enums\Price;
use App\Domains\Bookings\Events\BookingCreatedEvent;
use App\Domains\Bookings\Events\TicketAddedEvent;
use Illuminate\Support\Str;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class BookingAggregateRoot extends AggregateRoot
{
    public function createBooking(CreateBookingCmd $command): self
    {
        $this->recordThat(new BookingCreatedEvent(
            bookingUuid: $this->uuid(),
            customerEmail: $command->getUserEmail(),
            customerName: $command->getUserName(),
            customerPhone: $command->getUserPhone(),
        ));

        return $this;
    }

    public function addTickets(AddTicketsCmd $command): self
    {
        for ($i = 0; $i < $command->quantity; $i++) {
            try {
                $ticketUuid = $command->getUuids()[$i];
            } catch (\Exception $ex) {
                $ticketUuid = Str::uuid();
            }

            $this->recordThat(new TicketAddedEvent(
                $ticketUuid,
                $this->uuid(),
                Price::JOINED_TRIP->value,
            ));
        }

        return $this;
    }
}
