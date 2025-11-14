<?php

namespace App\Livewire\Admin;

use App\Models\MenuCategory;
use App\Models\MenuItem;
use Livewire\Component;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class MenuUpdateItem extends ModalComponent
{

    use WithFileUploads;

    public $ItemId;
    public $name;
    public $price;
    public $menu_category_id;
    public $image;
    public $menu_categories;
    public $existingImage;

    public function mount($ItemId)
    {
        $item = MenuItem::findOrFail($ItemId);

        $this->ItemId = $item->id;
        $this->name = $item->name;
        $this->price = $item->price;
        $this->menu_category_id = $item->menu_category_id;
        $this->existingImage = $item->image;
    }

    public function update()
    {

        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'menu_category_id' => 'required|exists:menu_categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($this->image) {
            $validated['image'] = $this->image->store('menu', 'public');
        } else {
            $validated['image'] = $this->existingImage;
        }

        $menuItem = MenuItem::findOrFail($this->ItemId);
        $menuItem->update($validated);

        $this->dispatch('MenuItemUpdated');
        $this->closeModal();
    }
    public function render()
    {
        return view('livewire.admin.menu-update-item', [
            'categories' => MenuCategory::all(),
        ]);
    }
}
