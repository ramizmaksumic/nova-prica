<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\RequiresAdmin;
use App\Models\Table;
use Livewire\Component;
use Livewire\WithPagination;

class Tables extends Component
{
    use RequiresAdmin;

    use WithPagination;

    protected $listeners = ['tableUpdated' => '$refresh', 'tableDeleted' => '$refresh', 'tableCreated' => '$refresh'];


    public function render()
    {
        return view('livewire.admin.tables', [
            'tables' => Table::paginate(10),
        ])->extends('admin.dashboard')->section('content');
    }
}
