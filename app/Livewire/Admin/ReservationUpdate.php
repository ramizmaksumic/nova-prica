<?php

namespace App\Livewire\Admin;

use App\Mail\ReservationUpdateMail;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class ReservationUpdate extends ModalComponent
{
    public $reservationId;
    public $event;
    public $table;
    public $num_people;
    public $notes;
    public $status;

    public function mount($reservationId)
    {

        $reservation = Reservation::findOrFail($reservationId);

        $this->reservationId = $reservation->id;
        $this->event = $reservation->event_id;
        $this->table = $reservation->table_id;
        $this->num_people = $reservation->num_people;
        $this->status = $reservation->status;
        $this->notes = $reservation->notes;
    }

    public function update()
    {
        $validated = $this->validate([
            'event' => 'required|exists:events,id',
            'table' => 'required|exists:tables,id',
            'num_people' => 'required|integer|min:1',
            'status' => 'required|string|in:active,pending,cancelled',
            'notes' => 'nullable|string|max:500',
        ]);

        $reservation = Reservation::findOrFail($this->reservationId);
        $reservation->update([
            'event_id' => $this->event,
            'table_id' => $this->table,
            'num_people' => $this->num_people,
            'status' => $this->status,
            'notes' => $this->notes,
        ]);

        $reservation->load('user');

        // Email korisniku
        Mail::to($reservation->user->email)
            ->cc('info@novaprica.ba')
            ->queue(new ReservationUpdateMail($reservation));





        $this->dispatch('reservationUpdated'); // osvježavanje liste
        $this->closeModal();
    }



    public function render()
    {
        return view('livewire.admin.reservation-update', [
            'events' => \App\Models\Event::all(),
            'tables' => \App\Models\Table::all(),
        ]);
    }
}
