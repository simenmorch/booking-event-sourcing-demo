<?php

namespace App\Domains\Bookings\Projectors;

use App\Domains\Bookings\Events\BookingCreatedEvent;
use App\Domains\Bookings\Events\InvoiceCreatedEvent;
use App\Domains\Bookings\Events\InvoiceUpdatedEvent;
use App\Domains\Bookings\Projections\BookingProjection;
use App\Domains\Bookings\Services\BookingService;
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
                'type' => $event->type,
                'created_at' => $event->createdAt(),
            ]);
    }

    public function onInvoiceCreated(InvoiceCreatedEvent $event): void
    {
        $booking = BookingService::fetchBooking($event->bookingUuid);

        $booking->writeable()->update([
            'current_invoice_uuid' => $event->invoiceUuid
        ]);
    }

    public function onInvoiceUpdated(InvoiceUpdatedEvent $event)
    {
        $booking = BookingService::fetchBooking($event->bookingUuid);

        $booking->writeable()->update([
            'current_invoice_uuid' => $event->newInvoiceUuid
        ]);
    }

    public function resetState(): void
    {
        BookingProjection::query()->delete();
    }
}
