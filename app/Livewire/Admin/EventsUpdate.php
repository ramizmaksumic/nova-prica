<?php

namespace App\Livewire\Admin;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class EventsUpdate extends ModalComponent
{

    use WithFileUploads;

    public $eventId;
    public $name;
    public $description;
    public $price;
    public $date;
    public $status;
    public $image;

    public $newImage;


    public function mount($eventId)
    {
        $event = Event::findOrFail($eventId);
        $this->eventId = $event->id;
        $this->name = $event->name;
        $this->description = $event->description;
        $this->price = $event->price;
        $this->date = $event->date;
        $this->status = $event->status;
        $this->image = $event->image;
    }

    public function update()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'price' => 'integer|nullable',
            'date' => 'required|date',
            'status' => 'required|string',
            'newImage' => 'nullable|image|max:2048',
        ]);

        if ($this->newImage) {
            $validated['image'] = $this->newImage->store('events', 'public');
        } else {
            $validated['image'] = $this->image;
        }

        $event = Event::findOrFail($this->eventId);
        $event->update($validated);

        $this->closeModal();
        $this->dispatch('eventUpdated');
    }

    public function render()
    {
        return view('livewire.admin.events-update');
    }
}
