<?php

namespace Database\Factories;

use App\Domains\Bookings\Events\BookingCreatedEvent;
use Faker\Factory;
use Illuminate\Support\Str;

class BookingInitializedEventFactory
{
    public static function create(): BookingCreatedEvent
    {
        $faker = Factory::create('nb_NO');

        $uuid = Str::uuid();

        return new BookingCreatedEvent(
            $uuid,
            customerEmail: $faker->email,
            customerName: $faker->firstName.' '.$faker->lastName,
            customerPhone: $faker->phoneNumber,
        );
    }
}
