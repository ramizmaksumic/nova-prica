<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\RequiresAdmin;
use App\Mail\ReservationDeleteMail;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use LivewireUI\Modal\ModalComponent;

class ReservationDelete extends ModalComponent
{
    use RequiresAdmin;

    public $reservationId;

    public function mount($reservationId)
    {
        $this->reservationId = $reservationId;
    }

    public function deleteReservation()
    {
        $reservation = Reservation::find($this->reservationId);

        if ($reservation) {
            // Mail se pravi prije brisanja jer čuva podatke rezervacije, a ne model.
            $mail = new ReservationDeleteMail($reservation);
            $email = $reservation->status !== Reservation::STATUS_CANCELLED ? $reservation->contactEmail() : null;

            $reservation->delete();

            if ($email) {
                Mail::to($email)->cc(config('mail.admin_email'))->queue($mail);
            }

            session()->flash('message', 'Rezervacija je uspješno izbrisana.');
            $this->dispatch('reservationDeleted');
        }

        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.reservation-delete');
    }
}
