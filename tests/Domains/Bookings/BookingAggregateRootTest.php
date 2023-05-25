<?php

namespace Tests\Domains\Bookings;

use App\Domains\Bookings\BookingAggregateRoot;
use App\Domains\Bookings\Commands\AddTicketsCmd;
use App\Domains\Bookings\Commands\CreateBookingCmd;
use App\Domains\Bookings\Enums\Price;
use App\Domains\Bookings\Events\BookingCreatedEvent;
use App\Domains\Bookings\Events\TicketAddedEvent;
use App\Domains\Bookings\Projections\BookingProjection;
use Faker\Factory;
use Illuminate\Support\Str;
use Spatie\EventSourcing\Commands\CommandBus;
use Tests\TestCase;

class BookingAggregateRootTest extends TestCase
{
    private CommandBus $bus;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bus = app(CommandBus::class);
    }


    /** test */
    public function test_add_booking()
    {
        $faker = Factory::create('nb_NO');

        $uuid = Str::uuid();

        $this->bus->dispatch(new CreateBookingCmd(
            $uuid,
            'simen@adventuretech.no',
            'Simen Mørch',
            '47661720',
        ));

        $this->assertDatabaseHas((new BookingProjection())->getTable(), [
            'customer_email' => 'simen@adventuretech.no',
        ]);

    }

    /** test */
    public function test_add_tickets()
    {
        $uuid = Str::uuid();
        $addTicketsCommand = new AddTicketsCmd($uuid, 2);
        $uuids = $addTicketsCommand->getUuids();

        BookingAggregateRoot::fake($uuid)
            ->given(
                new BookingCreatedEvent($uuid, 'simenmoerch@gmail.com', 'Simen Mørch', '47661720',)
            )
            ->when(function (BookingAggregateRoot $aggregateRoot) use ($uuid, $addTicketsCommand) {
                $aggregateRoot->addTickets($addTicketsCommand);
            })
            ->assertRecorded([
                new TicketAddedEvent($uuids[0], $uuid, Price::JOINED_TRIP->value),
                new TicketAddedEvent($uuids[1], $uuid, Price::JOINED_TRIP->value),
            ]);
    }
}
