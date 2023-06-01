<?php

namespace App\Domains\Bookings\Commands;

use App\Domains\Bookings\BookingAggregateRoot;
use App\Domains\Bookings\Services\BookingService;
use Spatie\EventSourcing\Commands\AggregateUuid;
use Spatie\EventSourcing\Commands\HandledBy;

#[HandledBy(BookingAggregateRoot::class)]
class UpdateInvoiceCmd
{
    public function __construct(
        #[AggregateUuid] public string $bookingUuid,
        public string $invoiceUuid,
        public string $currentInvoiceUuid,
    ) {
    }

    public function getBookingUuid(): string
    {
        return $this->bookingUuid;
    }

    public function getInvoiceUuid(): string
    {
        return $this->invoiceUuid;
    }

    public function getCurrentInvoiceUuid(): string
    {
        return $this->currentInvoiceUuid;
    }

    public function getNewTotalPrice(): int
    {
        return BookingService::calculateTotalPrice($this->getBookingUuid());
    }
}
