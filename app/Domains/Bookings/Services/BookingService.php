<?php

namespace App\Domains\Bookings\Services;

use App\Domains\Bookings\Projections\BookingProjection;
use App\Domains\Bookings\Projections\TicketProjection;
use Illuminate\Support\Collection;

final class BookingService
{
    public static function calculateTotalPrice(string $bookingUuid)
    {
        $tickets = BookingService::fetchTickets($bookingUuid);

        return $tickets->pluck('current_price')->sum();
    }

    public static function fetchBooking(string $bookingUuid)
    {
        return BookingProjection::with('currentInvoice')->findOrFail($bookingUuid);
    }

    public static function fetchTickets(string $bookingUuid): Collection
    {
        return TicketProjection::where('booking_uuid', $bookingUuid)->get();
    }
}
