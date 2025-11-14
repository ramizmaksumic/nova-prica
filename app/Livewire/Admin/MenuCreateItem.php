<?php

namespace App\Livewire\Admin;

use App\Models\MenuCategory;
use App\Models\MenuItem;
use Livewire\Component;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class MenuCreateItem extends ModalComponent
{

    use WithFileUploads;

    public $name;
    public $price;
    public $image;
    public $menu_categories;
    public $menu_category_id;

    public function save()
    {
        $validated = $this->validate([
            'menu_category_id' => 'required|exists:menu_categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($this->image) {
            $validated['image'] = $this->image->store('menu', 'public');
        }

        MenuItem::create($validated);

        $this->dispatch('menuItemCreated');
        $this->closeModal();
    }
    public function render()
    {
        return view('livewire.admin.menu-create-item', [
            'categories' => MenuCategory::all(),
        ]);
    }
}
