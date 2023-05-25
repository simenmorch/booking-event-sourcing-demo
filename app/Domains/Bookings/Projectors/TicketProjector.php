<?php

namespace App\Domains\Bookings\Projectors;

use App\Domains\Bookings\Events\TicketAddedEvent;
use App\Domains\Bookings\Projections\TicketProjection;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class TicketProjector extends Projector
{
    public function onTicketAdded(TicketAddedEvent $event): void
    {
        TicketProjection::new()
            ->writeable()
            ->create([
                'uuid' => $event->uuid,
                'booking_uuid' => $event->bookingUuid,
                'current_price' => $event->currentPrice,
            ]);
    }
}
