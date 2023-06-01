<?php

namespace App\Domains\Bookings\Commands;

use App\Domains\Bookings\BookingAggregateRoot;
use App\Domains\Bookings\Enums\Price;
use App\Domains\Bookings\Projections\BookingProjection;
use Illuminate\Support\Str;
use Spatie\EventSourcing\Commands\AggregateUuid;
use Spatie\EventSourcing\Commands\HandledBy;

#[HandledBy(BookingAggregateRoot::class)]
class AddTicketsCmd
{
    private array $uuids;

    public function __construct(
        #[AggregateUuid] public string $bookingUuid,
        private readonly int $quantity,
    ) {
        $this->createUuids();
    }

    private function createUuids(): void
    {
        for ($i = 0; $i < $this->quantity; $i++) {
            $this->uuids[$i] = Str::uuid();
        }
    }

    public function getUuids():array
    {
        return $this->uuids;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getCurrentPrice(): int
    {
        $booking = BookingProjection::find($this->bookingUuid);

        return Price::fromBookingType($booking->type)->value;
    }
}
