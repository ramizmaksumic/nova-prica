<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Reservation;
use App\Models\Table;
use Livewire\Component;

class AdminDashboard extends Component
{

    public $eventsCount;
    public $reservationsCount;

    public $reservationPending;

    public $reservationActive;

    public function mount()
    {
        $this->eventsCount = Event::count();
        $this->reservationsCount = Reservation::count();
        $this->reservationActive = Reservation::where('status', 'active')->count();
        $this->reservationPending = Reservation::where('status', 'pending')->count();
    }
    public function render()
    {
        return view('livewire.admin.dashboard')->extends('admin.dashboard')->section('content');
    }
}
