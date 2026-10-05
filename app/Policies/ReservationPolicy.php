<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;

class ReservationPolicy
{
    /**
     * Korisnik može mijenjati samo svoju rezervaciju, i to samo dok događaj nije prošao
     * i dok rezervacija nije otkazana.
     */
    public function update(User $user, Reservation $reservation): bool
    {
        return $this->ownsEditableReservation($user, $reservation);
    }

    public function delete(User $user, Reservation $reservation): bool
    {
        return $this->ownsEditableReservation($user, $reservation);
    }

    private function ownsEditableReservation(User $user, Reservation $reservation): bool
    {
        return $reservation->user_id === $user->id
            && $reservation->status !== Reservation::STATUS_CANCELLED
            && $reservation->event
            && ! $reservation->event->hasEnded();
    }
}
