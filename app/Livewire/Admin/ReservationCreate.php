<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\RequiresAdmin;
use App\Models\Event;
use App\Models\Reservation;
use App\Models\Table;
use App\Services\ReservationService;
use LivewireUI\Modal\ModalComponent;

/**
 * Admin unosi rezervaciju za gosta (npr. telefonom) koji nema korisnički nalog.
 */
class ReservationCreate extends ModalComponent
{
    use RequiresAdmin;

    public $event_id;
    public $table_id;
    public $num_people;
    public $notes;
    public $guest_name;
    public $guest_phone;
    public $status = Reservation::STATUS_ACTIVE;

    public function updatedEventId()
    {
        $this->table_id = null;
    }

    public function save(ReservationService $reservations)
    {
        $validated = $this->validate([
            'event_id' => 'required|exists:events,id',
            'table_id' => 'required|exists:tables,id',
            'num_people' => 'required|integer|min:1|max:30',
            'guest_name' => 'required|string|max:255',
            'guest_phone' => 'nullable|string|max:25',
            'status' => 'required|in:' . implode(',', Reservation::BLOCKING_STATUSES),
            'notes' => 'nullable|string|max:500',
        ]);

        $reservations->create($validated, byAdmin: true);

        $this->dispatch('reservationCreated');
        $this->closeModal();
    }

    public function render()
    {
        $takenTableIds = $this->event_id
            ? Reservation::where('event_id', $this->event_id)->blocking()->pluck('table_id')
            : collect();

        return view('livewire.admin.reservation-create', [
            'events' => Event::notEnded()->orderBy('date')->get(),
            'tables' => Table::whereNotIn('id', $takenTableIds)->orderBy('name')->get(),
        ]);
    }
}
