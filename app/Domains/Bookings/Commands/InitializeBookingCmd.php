<?php

namespace App\Domains\Bookings\Commands;

use App\Domains\Bookings\BookingAggregateRoot;
use App\Domains\Bookings\Enums\BookingType;
use App\Domains\Bookings\Enums\Price;
use Spatie\EventSourcing\Commands\AggregateUuid;
use Spatie\EventSourcing\Commands\HandledBy;

#[HandledBy(BookingAggregateRoot::class)]
class InitializeBookingCmd
{
    public function __construct(
        #[AggregateUuid] public string $bookingUuid,
        private readonly string $userEmail,
        private readonly string $userName,
        private readonly ?string $userPhone,
        private readonly BookingType $type,
        private readonly int $guests,
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

    /**
     * @return BookingType
     */
    public function getType(): BookingType
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getGuests(): int
    {
        return $this->guests;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return Price::calculate($this->getType(), $this->getGuests());
    }

}
