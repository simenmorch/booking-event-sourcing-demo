<?php

namespace App\Http\Controllers;

use App\Domains\Bookings\Commands\AddTicketsCmd;
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

        return response()->json(null, 201);
    }
}
