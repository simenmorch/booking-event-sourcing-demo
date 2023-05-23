<?php

namespace App\Domains\Bookings\Projectors;

use App\Domains\Bookings\Events\BookingInitializedEvent;
use App\Domains\Bookings\Projections\BookingProjection;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class BookingProjector extends Projector
{
    public function onBookingInitialized(BookingInitializedEvent $event): void
    {
        BookingProjection::new()
            ->writeable()
            ->create([
                'uuid' => $event->bookingUuid,
                'customer_name' => $event->customerName,
                'customer_email' => $event->customerEmail,
                'customer_phone' => $event->customerPhone,
                'type' => $event->type->value,
                'guests' => $event->guests,
                'price' => $event->price,
            ]);
    }
}
