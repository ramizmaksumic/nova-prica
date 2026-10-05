<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\RequiresAdmin;
use App\Models\Event;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class EventsUpdate extends ModalComponent
{
    use RequiresAdmin;

    use WithFileUploads;

    public $eventId;
    public $name;
    public $description;
    public $price;
    public $date;
    public $status;
    public $image;
    public $link;

    public $newImage;

    public function mount($eventId)
    {
        $event = Event::findOrFail($eventId);
        $this->eventId = $event->id;
        $this->name = $event->name;
        $this->description = $event->description;
        $this->price = $event->price;
        // datetime-local input očekuje format Y-m-d\TH:i
        $this->date = $event->date->format('Y-m-d\TH:i');
        $this->status = $event->status;
        $this->image = $event->image;
        $this->link = $event->link;
    }

    public function update()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'price' => 'nullable|integer|min:0|max:65000',
            'date' => 'required|date',
            'status' => 'required|in:active,inactive',
            'newImage' => 'nullable|image|max:2048',
            'link' => 'nullable|url|max:255',
        ]);

        unset($validated['newImage']);
        $validated['link'] = $validated['link'] ?: null;

        if ($this->newImage) {
            $validated['image'] = $this->newImage->store('events', 'public');
            $this->image = $validated['image'];
        }

        $event = Event::findOrFail($this->eventId);

        // Ako se događaj pomjeri na drugi dan, podsjetnik treba ponovo poslati.
        if ($event->date->toDateString() !== \Carbon\Carbon::parse($validated['date'])->toDateString()) {
            $validated['reminder_sent'] = false;
        }

        $event->update($validated);

        $this->dispatch('eventUpdated')->to(Events::class);

        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.events-update');
    }
}
