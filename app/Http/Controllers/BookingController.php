<?php

namespace App\Http\Controllers;

use App\Domains\Bookings\Commands\CreateBookingCmd;
use App\Domains\Bookings\Projections\BookingProjection;
use Illuminate\Support\Str;
use Spatie\EventSourcing\Commands\CommandBus;

class BookingController extends Controller
{
    public function index()
    {
        return response()->json([
            'bookings' => BookingProjection::all()
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'type' => 'required|string',
        ]);

        $uuid = Str::uuid();

        $bus = app(CommandBus::class);

        $bus->dispatch(new CreateBookingCmd(
            $uuid,
            $data['email'],
            $data['name'],
            $data['phone'],
            $data['type'],
        ));

        return response()->json([BookingProjection::find($uuid)]);
    }
}
