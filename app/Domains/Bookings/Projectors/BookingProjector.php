<?php

namespace App\Domains\Bookings\Projectors;

use App\Domains\Bookings\Events\BookingCreatedEvent;
use App\Domains\Bookings\Events\InvoiceCreated;
use App\Domains\Bookings\Projections\BookingProjection;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class BookingProjector extends Projector
{
    public function onBookingCreated(BookingCreatedEvent $event): void
    {
        BookingProjection::new()
            ->writeable()
            ->create([
                'uuid' => $event->bookingUuid,
                'customer_name' => $event->customerName,
                'customer_email' => $event->customerEmail,
                'customer_phone' => $event->customerPhone,
                'created_at' => $event->createdAt(),
            ]);
    }

    public function onInvoiceCreated(InvoiceCreated $event): void
    {
        $booking = BookingProjection::find($event->bookingUuid);

        $booking->writeable()->update([
            'current_invoice_uuid' => $event->invoiceUuid
        ]);
    }

    public function resetState(): void
    {

        BookingProjection::query()->delete();
    }
}
