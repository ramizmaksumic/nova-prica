<?php

namespace App\Livewire\Admin;

use App\Mail\ReservationDeleteMail;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class ReservationDelete extends ModalComponent
{

    public $reservationId;

    public function mount($reservationId)
    {
        $this->reservationId = $reservationId;
    }

    public function deleteReservation()
    {

        $reservation = Reservation::find($this->reservationId);

        if ($reservation) {
            $reservation->delete();
            session()->flash('message', 'Rezervacija je uspješno izbrisana.');
            $this->dispatch('reservationDeleted');
        }

        Mail::to(Auth::user()->email)->queue(new ReservationDeleteMail($reservation));

        $this->closeModal();
    }
    public function render()
    {
        return view('livewire.admin.reservation-delete');
    }
}
