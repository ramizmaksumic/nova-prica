<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_CANCELLED = 'cancelled';

    /** Statusi koji drže stol zauzetim za događaj. */
    public const BLOCKING_STATUSES = [self::STATUS_PENDING, self::STATUS_ACTIVE];

    public const STATUS_LABELS = [
        self::STATUS_PENDING => 'Na čekanju',
        self::STATUS_ACTIVE => 'Potvrđena',
        self::STATUS_CANCELLED => 'Otkazana',
    ];

    protected $with = [
        'event:id,name,date,status',
        'user:id,name,surname,email,phone',
        'table:id,name'
    ];

    protected $fillable = [
        'event_id',
        'user_id',
        'table_id',
        'status',
        'num_people',
        'notes',
        'guest_name',
        'guest_phone',
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function scopeBlocking(Builder $query): Builder
    {
        return $query->whereIn('status', self::BLOCKING_STATUSES);
    }

    public function statusLabel(): string
    {
        return self::STATUS_LABELS[$this->status] ?? ucfirst($this->status);
    }

    /** Ime gosta: za rezervacije koje je unio admin (telefonom) koristi se guest_name. */
    public function guestDisplayName(): string
    {
        if ($this->guest_name) {
            return $this->guest_name;
        }

        return trim(($this->user->name ?? '') . ' ' . ($this->user->surname ?? ''));
    }

    public function contactEmail(): ?string
    {
        return $this->user?->email;
    }

    public function contactPhone(): ?string
    {
        return $this->guest_phone ?: $this->user?->phone;
    }
}
