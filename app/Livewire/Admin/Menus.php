<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\RequiresAdmin;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use Livewire\Component;
use Livewire\WithPagination;

class Menus extends Component
{
    use RequiresAdmin;

    use WithPagination;

    protected $listeners = ['menuItemCreated' => '$refresh', 'MenuItemUpdated' => '$refresh', 'MenuItemDeleted' => '$refresh'];

    public $activeTab = 'Hrana'; // food | drinks

    public function setTab($tab)
    {
        $this->activeTab = $tab;

        $this->resetPage('foodPage');
        $this->resetPage('drinkPage');
    }

    public function render()
    {
        $foodItems = MenuItem::whereHas(
            'category',
            fn($q) =>
            $q->where('name', 'Hrana')
        )
            ->orderBy('name')
            ->paginate(10, ['*'], 'foodPage');

        $drinkItems = MenuItem::whereHas(
            'category',
            fn($q) =>
            $q->where('name', 'Pića')
        )
            ->orderBy('name')
            ->paginate(10, ['*'], 'drinkPage');

        return view('livewire.admin.menus', compact('foodItems', 'drinkItems'))
            ->extends('admin.dashboard')
            ->section('content');
    }
}
