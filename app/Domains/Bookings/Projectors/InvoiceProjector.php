<?php

namespace App\Domains\Bookings\Projectors;

use App\Domains\Bookings\Events\InvoiceCreated;
use App\Domains\Bookings\Events\TicketAddedEvent;
use App\Domains\Bookings\Projections\InvoiceProjection;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class InvoiceProjector extends Projector
{
    public function onInvoiceCreated(InvoiceCreated $event)
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

    public function onTicketAdded(TicketAddedEvent $event)
    {
        // Figure out if there are a current invoice registered.
        // Credit it
        //Create a new one
        //Update the booking with the new invoice
    }

    public function resetState(): void
    {
        InvoiceProjection::query()->delete();
    }
}
