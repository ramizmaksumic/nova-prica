<?php

namespace App\Livewire\Admin;

use LivewireUI\Modal\ModalComponent;
use App\Models\Reservation;
use App\Models\Event;
use App\Models\Table;

class ReservationCreate extends ModalComponent
{
    public $event_id;
    public $table_id;
    public $num_people;
    public $notes;


    public function save()
    {
        $this->validate([
            'event_id' => 'required|exists:events,id',
            'table_id' => 'required|exists:tables,id',
            'num_people' => 'required|integer|min:1',

        ]);

        Reservation::create([
            'event_id' => $this->event_id,
            'table_id' => $this->table_id,
            'num_people' => $this->num_people,
            'notes' => $this->notes,
            'user_id' => auth()->id(),
            'status' => 'pending',
        ]);

        $this->closeModal(); // automatski zatvara modal
        $this->dispatch('reservationCreated'); // obavještava parent komponentu
    }

    public function render()
    {
        return view('livewire.admin.reservation-create', [
            'events' => Event::all(),
            'tables' => Table::where('is_reserved', false)->get(),
        ]);
    }
}
