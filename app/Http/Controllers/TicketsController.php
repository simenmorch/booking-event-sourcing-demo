<?php

namespace App\Http\Controllers;

use App\Domains\Bookings\Commands\AddTicketsCmd;
use App\Domains\Bookings\Commands\UpdateInvoiceCmd;
use App\Domains\Bookings\Services\BookingService;
use Illuminate\Support\Str;
use Spatie\EventSourcing\Commands\CommandBus;

class TicketsController extends Controller
{
    public function store(string $bookingUuid)
    {
        $data = request()->validate([
            'quantity' => 'required|int',
        ]);

        $bus = app(CommandBus::class);

        $bus->dispatch(new AddTicketsCmd($bookingUuid, $data['quantity']));

        $booking = BookingService::fetchBooking($bookingUuid);

        $newTotalPrice = BookingService::calculateTotalPrice($bookingUuid);

        if (isset($booking->currentInvoice) && $booking->currentInvoice->total_price !== $newTotalPrice) {
            $newInvoiceUuid = Str::uuid();

            $bus->dispatch(new UpdateInvoiceCmd(
                $bookingUuid,
                $newInvoiceUuid,
                $booking->currentInvoice->uuid,
            ));
        }

        return response()->json(null, 201);
    }
}
