<?php

namespace App\Livewire;

use App\Models\MenuCategory;
use App\Models\MenuItem;
use Livewire\Component;

class Menu extends Component
{

    public $activeCategory;

    public function mount()
    {
        $this->activeCategory = MenuCategory::first()->id ?? null;
    }

    public function setCategory($id)
    {
        $this->activeCategory = $id;
    }
    public function render()
    {
        return view('livewire.menu', [
            'categories' => MenuCategory::all(),
            'items' => MenuItem::where('menu_category_id', $this->activeCategory)->get(),
        ]);
    }
}
