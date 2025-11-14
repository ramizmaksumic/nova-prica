<?php

namespace App\Livewire\Admin;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class EventsCreate extends ModalComponent
{

    use WithFileUploads;

    public $name;
    public $description;
    public $price;
    public $date;
    public $status;
    public $image;

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'integer',
            'date' => 'required|date',
            'status' => 'string|required',
            'image' => 'nullable|image|max:2048'
        ]);

        $validated['date'] = \Carbon\Carbon::parse($this->date)->format('Y-m-d H:i:s');

        if ($this->image) {
            $validated['image'] = $this->image->store('events', 'public');
        }

        Event::create($validated);

        $this->closeModal();
        $this->dispatch('eventCreated');
    }

    public function render()
    {
        return view('livewire.admin.events-create');
    }
}
