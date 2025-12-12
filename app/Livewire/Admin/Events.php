<?php

namespace App\Livewire\Admin;

use Livewire\Component;

use App\Models\Event;
use Livewire\WithPagination;

class Events extends Component
{

    use WithPagination;
    protected $listeners = [
        'eventUpdated' => '$refresh',
        'eventCreated' => '$refresh',
        'eventDeleted' => '$refresh',
    ];

    public function deleteEvent($id)
    {
        Event::find($id)?->delete();

        session()->flash('message', 'Događaj je uspješno obrisan.');
    }

    public function render()
    {
        return view('livewire.admin.events', [
            'events' => Event::paginate(10),
        ])->extends('admin.dashboard')->section('content');
    }
}
