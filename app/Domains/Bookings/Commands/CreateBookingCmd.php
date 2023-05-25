<?php

namespace App\Domains\Bookings\Commands;

use App\Domains\Bookings\BookingAggregateRoot;
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
    ) {
    }

    /**
     * @return string
     */
    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @return string|null
     */
    public function getUserPhone(): ?string
    {
        return $this->userPhone;
    }
}
