<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\RequiresAdmin;
use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;

class Events extends Component
{
    use RequiresAdmin;

    use WithPagination;

    protected $listeners = [
        'eventUpdated' => '$refresh',
        'eventCreated' => '$refresh',
        'eventDeleted' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.admin.events', [
            'events' => Event::orderByDesc('date')->paginate(10),
        ])->extends('admin.dashboard')->section('content');
    }
}
