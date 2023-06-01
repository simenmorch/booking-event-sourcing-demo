<?php

namespace App\Domains\Bookings\Projections;

use App\Domains\Bookings\Enums\BookingType;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Spatie\EventSourcing\Projections\Projection;

class BookingProjection extends Projection
{
    protected $table = 'bookings';

    protected $guarded = ['id'];

    public function getTypeAttribute(): BookingType
    {
        return BookingType::from($this->attributes['type']);
    }

    public function setTypeAttribute(BookingType|string $bookingType):void
    {
        $this->attributes['type'] = $bookingType;

        if ($bookingType instanceof BookingType) {
            $this->attributes['type'] = Str::lower($bookingType->name);
        }
    }

    public function currentInvoice(): HasOne
    {
        return $this->hasOne(InvoiceProjection::class, 'uuid', 'current_invoice_uuid');
    }
}
