<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * Klub radi do jutra: događaj traje do ovog sata sljedećeg dana (npr. subota → nedjelja 06:00).
     * Vrijedi i za događaje spremljene samo s datumom (00:00).
     */
    public const CLOSING_HOUR_NEXT_DAY = 6;

    protected $fillable = [
        'name',
        'description',
        'price',
        'date',
        'status',
        'image',
        'link',
        'reminder_sent',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    protected $casts = [
        'date' => 'datetime',
        'reminder_sent' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    /** Aktivni događaji koji još nisu završili, najbliži prvi. */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->active()->notEnded()->orderBy('date');
    }

    public function scopeNotEnded(Builder $query): Builder
    {
        return $query->where('date', '>=', self::earliestNotEndedDate());
    }

    /**
     * Najraniji početak događaja koji još traje: događaj s datumom D završava D+1 u CLOSING_HOUR,
     * pa još traju svi događaji od dana (sada - 1 dan - CLOSING_HOUR) nadalje.
     */
    public static function earliestNotEndedDate(): \Carbon\Carbon
    {
        $limit = now()->subDay()->subHours(self::CLOSING_HOUR_NEXT_DAY);

        return $limit->copy()->startOfDay()->equalTo($limit)
            ? $limit
            : $limit->copy()->addDay()->startOfDay();
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function endsAt(): \Carbon\Carbon
    {
        return $this->date->copy()->addDay()->setTime(self::CLOSING_HOUR_NEXT_DAY, 0);
    }

    public function hasEnded(): bool
    {
        return $this->endsAt()->isPast();
    }

    /** Rezervacije su moguće samo za aktivne događaje koji nisu prošli i nemaju Entrio prodaju. */
    public function acceptsReservations(): bool
    {
        return $this->isActive() && ! $this->hasEnded() && empty($this->link);
    }
}
