<?php

namespace App\Livewire\Admin;

use App\Models\Event;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class EventDeleteConfirm extends ModalComponent
{


    public $eventId;

    public function mount($eventId)
    {
        $this->eventId = $eventId;
    }

    public function deleteEvent()
    {
        $event = Event::find($this->eventId);

        if ($event) {
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
