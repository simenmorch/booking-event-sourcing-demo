<?php

namespace App\Http\Controllers;

use App\Domains\Bookings\Commands\CreateInvoiceCmd;
use App\Domains\Bookings\Projections\BookingProjection;
use Illuminate\Support\Str;
use Spatie\EventSourcing\Commands\CommandBus;

class InvoicesController extends Controller
{
    public function store(string $bookingUuid)
    {
        $bus = app(CommandBus::class);

        $uuid = Str::uuid();

        $bus->dispatch(new CreateInvoiceCmd(
            $bookingUuid,
            $uuid,
        ));

        return response()->json(null, 201);
    }

    public function current($bookingUuid)
    {
       $booking = BookingProjection::find($bookingUuid);

       return $booking->currentInvoice()->get();
    }
}
