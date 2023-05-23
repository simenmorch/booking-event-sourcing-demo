<?php

namespace Database\Factories;

use App\Domains\Bookings\Enums\BookingType;
use App\Domains\Bookings\Events\BookingInitializedEvent;
use Faker\Factory;

class BookingInitializedEventFactory
{
    public static function create(): BookingInitializedEvent
    {
        $faker = Factory::create('nb_NO');

        return new BookingInitializedEvent(
            customerEmail: $faker->email,
            customerName: $faker->firstName.' '.$faker->lastName,
            customerPhone: $faker->phoneNumber,
            type: BookingType::JOINED_TRIP
        );
    }
}
