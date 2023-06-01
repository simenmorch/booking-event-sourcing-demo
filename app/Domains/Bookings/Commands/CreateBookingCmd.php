<?php

namespace App\Domains\Bookings\Commands;

use App\Domains\Bookings\BookingAggregateRoot;
use App\Domains\Bookings\Enums\BookingType;
use Spatie\EventSourcing\Commands\AggregateUuid;
use Spatie\EventSourcing\Commands\HandledBy;

#[HandledBy(BookingAggregateRoot::class)]
class CreateBookingCmd
{
    public function __construct(
        #[AggregateUuid] public string $bookingUuid,
        private readonly string $userEmail,
        private readonly string $userName,
        private readonly ?string $userPhone,
        private readonly string $type,
    ) {
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getUserPhone(): ?string
    {
        return $this->userPhone;
    }

    public function getType():string
    {
       return $this->type;
    }
}
