<?php

namespace App\Domains\Bookings\Commands;

use App\Domains\Bookings\BookingAggregateRoot;
use Illuminate\Support\Str;
use Spatie\EventSourcing\Commands\AggregateUuid;
use Spatie\EventSourcing\Commands\HandledBy;

#[HandledBy(BookingAggregateRoot::class)]
class AddTicketsCmd
{
    private array $uuids;

    public function __construct(
        #[AggregateUuid] public string $bookingUuid,
        public int $quantity,
    ) {
        $this->createUuids();
    }

    private function createUuids()
    {
        for ($i = 0; $i < $this->quantity; $i++) {
            $this->uuids[$i] = Str::uuid();
        }
    }

    public function getUuids()
    {
        return $this->uuids;
    }
}
