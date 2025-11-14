<?php

namespace App\Livewire\Admin;

use App\Models\MenuCategory;
use App\Models\MenuItem;
use Livewire\Component;

class Menus extends Component
{

    protected $listeners = ['menuItemCreated' => 'refresh', 'MenuItemUpdated' => 'refresh', 'MenuItemDeleted' => 'refresh'];

    public $activeTab = 'Hrana'; // food | drinks

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        $foodItems = MenuItem::whereHas('category', fn($q) => $q->where('name', 'Hrana'))->get();
        $drinkItems = MenuItem::whereHas('category', fn($q) => $q->where('name', 'Pića'))->get();

        return view('livewire.admin.menus', compact('foodItems', 'drinkItems'))
            ->extends('admin.dashboard')
            ->section('content');
    }
}
