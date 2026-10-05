<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\RequiresAdmin;
use App\Models\Event;
use LivewireUI\Modal\ModalComponent;

class EventDeleteConfirm extends ModalComponent
{
    use RequiresAdmin;

    public $eventId;
    public ?string $blockedReason = null;

    public function mount($eventId)
    {
        $this->eventId = $eventId;
    }

    public function deleteEvent()
    {
        $event = Event::find($this->eventId);

        if ($event) {
            // Brisanje događaja kaskadno briše rezervacije; za nadolazeći događaj to se ne dozvoljava.
            $activeReservations = $event->reservations()->blocking()->count();

            if ($activeReservations > 0 && ! $event->hasEnded()) {
                $this->blockedReason = "Događaj ima {$activeReservations} aktivnih rezervacija. Umjesto brisanja postavite ga kao neaktivan ili prvo otkažite rezervacije.";
                return;
            }

            $event->delete();
            session()->flash('message', 'Događaj je uspješno izbrisan.');
            $this->dispatch('eventDeleted');
        }

        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.event-delete-confirm');
    }
}
