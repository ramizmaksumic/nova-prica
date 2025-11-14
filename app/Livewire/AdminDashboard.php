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
    public $tablesCount;

    public $reservationPending;

    public function mount()
    {
        $this->eventsCount = Event::count();
        $this->reservationsCount = Reservation::count();
        $this->tablesCount = Table::count();
        $this->reservationPending = Reservation::where('status', 'pending')->count();
    }
    public function render()
    {
        return view('livewire.admin.dashboard')->extends('admin.dashboard')->section('content');
    }
}
