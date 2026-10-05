<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\RequiresAdmin;
use App\Mail\ReservationUpdateMail;
use App\Models\Event;
use App\Models\Reservation;
use App\Models\Table;
use App\Services\ReservationService;
use Illuminate\Support\Facades\Mail;
use LivewireUI\Modal\ModalComponent;

class ReservationUpdate extends ModalComponent
{
    use RequiresAdmin;

    public $reservationId;
    public $event;
    public $table;
    public $num_people;
    public $notes;
    public $status;
    public $guest_name;
    public $guest_phone;
    public bool $isGuestReservation = false;

    public function mount($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);

        $this->reservationId = $reservation->id;
        $this->event = $reservation->event_id;
        $this->table = $reservation->table_id;
        $this->num_people = $reservation->num_people;
        $this->status = $reservation->status;
        $this->notes = $reservation->notes;
        $this->guest_name = $reservation->guest_name;
        $this->guest_phone = $reservation->guest_phone;
        $this->isGuestReservation = $reservation->user_id === null;
    }

    public function update(ReservationService $reservations)
    {
        $this->validate([
            'event' => 'required|exists:events,id',
            'table' => 'required|exists:tables,id',
            'num_people' => 'required|integer|min:1|max:30',
            'status' => 'required|string|in:' . implode(',', array_keys(Reservation::STATUS_LABELS)),
            'notes' => 'nullable|string|max:500',
            'guest_name' => $this->isGuestReservation ? 'required|string|max:255' : 'nullable',
            'guest_phone' => 'nullable|string|max:25',
        ]);

        $reservation = Reservation::findOrFail($this->reservationId);

        $data = [
            'event_id' => $this->event,
            'table_id' => $this->table,
            'num_people' => $this->num_people,
            'status' => $this->status,
            'notes' => $this->notes,
        ];
        if ($this->isGuestReservation) {
            $data['guest_name'] = $this->guest_name;
            $data['guest_phone'] = $this->guest_phone;
        }

        $reservations->update($reservation, $data);

        // Gost bez naloga nema email; za online rezervacije obavještava se korisnik.
        if ($email = $reservation->contactEmail()) {
            Mail::to($email)
                ->cc(config('mail.admin_email'))
                ->queue(new ReservationUpdateMail($reservation));
        }

        $this->dispatch('reservationUpdated'); // osvježavanje liste
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.reservation-update', [
            'events' => Event::orderByDesc('date')->get(['id', 'name', 'date']),
            'tables' => Table::orderBy('name')->get(['id', 'name', 'min_capacity', 'max_capacity']),
        ]);
    }
}
