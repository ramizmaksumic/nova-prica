<?php

namespace App\Livewire\Admin;

use Livewire\Component;

use App\Models\Event;

class Events extends Component
{
    protected $listeners = ['eventUpdated' => '$refresh', 'eventCreated' => '$refresh'];

    public $events;

    public function mount()
    {
        $this->events = Event::all();
    }

    public function deleteEvent($id)
    {
        $event = Event::find($id);

        if ($event) {
            $event->delete();
            $this->dispatch('eventDeleted');
            session()->flash('message', 'Događaj je uspješno obrisan.');
        }

        $this->events = \App\Models\Event::latest()->get();
    }

    public function render()
    {
        return view('livewire.admin.events')->extends('admin.dashboard')->section('content');
    }
}
