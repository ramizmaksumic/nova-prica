<?php

namespace App\Livewire\Admin;

use App\Models\Table;
use Livewire\Component;
use Livewire\WithPagination;

class Tables extends Component
{

    use WithPagination;

    protected $listeners = ['tableUpdated' => 'refresh', 'tableDeleted' => 'refresh', 'tableCreated' => 'refresh'];

    protected $casts = [
        'is_reserved' => 'boolean',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function render()
    {
        return view('livewire.admin.tables', [
            'tables' => Table::paginate(10),
        ])->extends('admin.dashboard')->section('content');
    }
}
