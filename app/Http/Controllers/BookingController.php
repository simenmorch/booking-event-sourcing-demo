<?php

namespace App\Http\Controllers;

use App\Domains\Bookings\Commands\InitializeBookingCmd;
use App\Domains\Bookings\Enums\BookingType;
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
            'guests' => 'required|int',
        ]);

        $uuid = Str::uuid();

        $bus = app(CommandBus::class);

        $bus->dispatch(new InitializeBookingCmd(
            $uuid,
            $data['email'],
            $data['name'],
            $data['phone'],
            BookingType::from($data['type']),
            $data['guests'],
        ));

        return response()->json([BookingProjection::find($uuid)]);
    }
}
