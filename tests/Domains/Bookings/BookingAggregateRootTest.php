<?php

namespace Tests\Domains\Bookings;

use App\Domains\Bookings\BookingAggregateRoot;
use App\Domains\Bookings\Commands\AddTicketsCmd;
use App\Domains\Bookings\Commands\CreateBookingCmd;
use App\Domains\Bookings\Commands\CreateInvoiceCmd;
use App\Domains\Bookings\Enums\Price;
use App\Domains\Bookings\Events\BookingCreatedEvent;
use App\Domains\Bookings\Events\TicketAddedEvent;
use App\Domains\Bookings\Projections\BookingProjection;
use App\Domains\Bookings\Projections\InvoiceProjection;
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
        $bookingUuid = Str::uuid();
        $addTicketsCommand = new AddTicketsCmd($bookingUuid, 2);
        $uuids = $addTicketsCommand->getUuids();

        BookingAggregateRoot::fake($bookingUuid)
            ->given(
                new BookingCreatedEvent($bookingUuid, 'simenmoerch@gmail.com', 'Simen Mørch', '47661720',)
            )
            ->when(function (BookingAggregateRoot $aggregateRoot) use ($bookingUuid, $addTicketsCommand) {
                $aggregateRoot->addTickets($addTicketsCommand);
            })
            ->assertRecorded([
                new TicketAddedEvent($bookingUuid, $uuids[0], Price::JOINED_TRIP->value),
                new TicketAddedEvent($bookingUuid, $uuids[1], Price::JOINED_TRIP->value),
            ]);
    }

    /** test */
    public function test_create_invoice()
    {
        $bookingUuid = Str::uuid();
        $invoiceUuid = Str::uuid();

        $this->bus->dispatch(new CreateBookingCmd(
            $bookingUuid,
            'simen@adventuretech.no',
            'Simen Mørch',
            '47661720',
        ));

        $this->bus->dispatch(new AddTicketsCmd(
            $bookingUuid,
            2,
        ));

        $this->bus->dispatch(new CreateInvoiceCmd($bookingUuid, $invoiceUuid));

        $this->assertDatabaseHas((new InvoiceProjection())->getTable(), [
            'booking_uuid' => $bookingUuid,
            'uuid' => $invoiceUuid,
            'total_price' => (Price::JOINED_TRIP->value * 2)
        ]);

        $booking = BookingProjection::with('currentInvoice')->find($bookingUuid);

        $this->assertEquals($invoiceUuid, $booking->currentInvoice->uuid);
    }
}
