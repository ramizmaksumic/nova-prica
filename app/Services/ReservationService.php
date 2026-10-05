<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Validation\ValidationException;

class ReservationService
{
    /** Koliko aktivnih rezervacija jedan korisnik smije imati za isti događaj. */
    public const MAX_PER_USER_PER_EVENT = 1;

    public const TABLE_TAKEN_MESSAGE = 'Ovaj stol je već rezervisan za izabrani događaj. Molimo izaberite drugi stol.';

    /**
     * Kreira rezervaciju. Unique indeks u bazi je konačna zaštita od duple rezervacije
     * kada više gostiju istovremeno klikne isti stol.
     *
     * @throws ValidationException
     */
    public function create(array $data, bool $byAdmin = false): Reservation
    {
        $event = Event::findOrFail($data['event_id']);
        $table = Table::findOrFail($data['table_id']);

        // Admin smije unijeti rezervaciju i za neaktivan događaj ili preko kapaciteta (dodatna stolica),
        // ali nikad za već zauzet stol.
        if (! $byAdmin) {
            $this->ensureEventAcceptsReservations($event);
            $this->ensureUserLimit($data['user_id'], $event->id);
            $this->ensureCapacity($table, (int) $data['num_people']);
        }

        $this->ensureTableFree($event->id, $table->id);

        try {
            return Reservation::create($data + ['status' => Reservation::STATUS_PENDING]);
        } catch (UniqueConstraintViolationException) {
            throw ValidationException::withMessages(['table_id' => self::TABLE_TAKEN_MESSAGE]);
        }
    }

    /**
     * Admin izmjena (može promijeniti događaj, stol i status).
     *
     * @throws ValidationException
     */
    public function update(Reservation $reservation, array $data): Reservation
    {
        $table = Table::findOrFail($data['table_id'] ?? $reservation->table_id);

        $status = $data['status'] ?? $reservation->status;
        if (in_array($status, Reservation::BLOCKING_STATUSES, true)) {
            $this->ensureTableFree(
                $data['event_id'] ?? $reservation->event_id,
                $table->id,
                ignoreId: $reservation->id,
            );
        }

        try {
            $reservation->update($data);
        } catch (UniqueConstraintViolationException) {
            throw ValidationException::withMessages(['table_id' => self::TABLE_TAKEN_MESSAGE]);
        }

        return $reservation;
    }

    public function ensureCapacity(Table $table, int $numPeople): void
    {
        if ($numPeople < $table->min_capacity || $numPeople > $table->max_capacity) {
            throw ValidationException::withMessages([
                'num_people' => "Za stol {$table->name} broj osoba mora biti između {$table->min_capacity} i {$table->max_capacity}.",
            ]);
        }
    }

    private function ensureEventAcceptsReservations(Event $event): void
    {
        if (! $event->acceptsReservations()) {
            throw ValidationException::withMessages([
                'event_id' => 'Za ovaj događaj trenutno nije moguće rezervisati stol.',
            ]);
        }
    }

    private function ensureUserLimit(int $userId, int $eventId): void
    {
        $count = Reservation::where('user_id', $userId)
            ->where('event_id', $eventId)
            ->blocking()
            ->count();

        if ($count >= self::MAX_PER_USER_PER_EVENT) {
            throw ValidationException::withMessages([
                'table_id' => 'Već imate rezervaciju za ovaj događaj. Možete je izmijeniti ili otkazati na svom profilu.',
            ]);
        }
    }

    private function ensureTableFree(int $eventId, int $tableId, ?int $ignoreId = null): void
    {
        $taken = Reservation::where('event_id', $eventId)
            ->where('table_id', $tableId)
            ->blocking()
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists();

        if ($taken) {
            throw ValidationException::withMessages(['table_id' => self::TABLE_TAKEN_MESSAGE]);
        }
    }
}
