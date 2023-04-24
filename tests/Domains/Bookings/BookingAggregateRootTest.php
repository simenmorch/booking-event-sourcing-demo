<?php

namespace Tests\Domains\Bookings;

use App\Domains\Bookings\BookingAggregateRoot;
use App\Domains\Bookings\Enums\BookingType;
use App\Domains\Bookings\Projections\BookingProjection;
use Illuminate\Support\Str;
use Tests\TestCase;

class BookingAggregateRootTest extends TestCase
{
    /** test */
    public function test_initialize()
    {
        $uuid = Str::uuid();

        $aggregateRoot = BookingAggregateRoot::retrieve($uuid);

        $aggregateRoot->initialize(
            'simen@adventuretech.no',
            'Simen Mørch',
            '47661720',
            BookingType::JOINED_TRIP,
        )->persist();

        $this->assertDatabaseHas((new BookingProjection())->getTable(), [
            'customer_email' => 'simen@adventuretech.no'
        ]);
    }
}
