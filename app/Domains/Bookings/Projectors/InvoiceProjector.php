<?php

namespace App\Domains\Bookings\Projectors;

use App\Domains\Bookings\Events\InvoiceCreatedEvent;
use App\Domains\Bookings\Events\InvoiceUpdatedEvent;
use App\Domains\Bookings\Projections\InvoiceProjection;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class InvoiceProjector extends Projector
{
    public function onInvoiceCreated(InvoiceCreatedEvent $event)
    {
        InvoiceProjection::new()
            ->writeable()
            ->create([
                'uuid' => $event->invoiceUuid,
                'booking_uuid' => $event->bookingUuid,
                'total_price' => $event->totalPrice,
                'created_at' => $event->createdAt(),
            ]);
    }

    public function onInvoiceUpdated(InvoiceUpdatedEvent $event)
    {
        InvoiceProjection::find($event->currentInvoiceUuid)
            ->writeable()
            ->update([
                'credited_at' => $event->createdAt()
            ]);

        InvoiceProjection::new()
            ->writeable()
            ->create([
                'uuid' => $event->newInvoiceUuid,
                'booking_uuid' => $event->bookingUuid,
                'total_price' => $event->newTotalPrice,
                'created_at' => $event->createdAt(),
            ]);
    }

    public function resetState(): void
    {
        InvoiceProjection::query()->delete();
    }
}
