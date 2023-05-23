<?php

namespace Tests\Domains\Bookings;

use App\Domains\Bookings\Commands\InitializeBookingCmd;
use App\Domains\Bookings\Enums\BookingType;
use App\Domains\Bookings\Projections\BookingProjection;
use Faker\Factory;
use Illuminate\Support\Str;
use Spatie\EventSourcing\Commands\CommandBus;
use Tests\TestCase;

class BookingAggregateRootTest extends TestCase
{
    /** test */
    public function test_initialize()
    {
        $faker = Factory::create('nb_NO');

        $uuid = Str::uuid();

        $bus = app(CommandBus::class);

        $bus->dispatch(new InitializeBookingCmd(
            $uuid,
            'simen@adventuretech.no',
            'Simen Mørch',
            '47661720',
            BookingType::JOINED_TRIP,
            2,
        ));

        $this->assertDatabaseHas((new BookingProjection())->getTable(), [
            'customer_email' => 'simen@adventuretech.no',
            'price' => 120,
        ]);

    }
}
