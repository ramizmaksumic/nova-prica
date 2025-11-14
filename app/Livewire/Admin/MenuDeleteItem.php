<?php

namespace App\Livewire\Admin;

use App\Models\MenuItem;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class MenuDeleteItem extends ModalComponent
{

    public $itemId;

    public function mount($itemId)
    {

        $this->itemId = $itemId;
    }

    public function deleteItem()
    {

        $item = MenuItem::findOrFail($this->itemId);

        if ($item) {
            $item->delete();
            session()->flash('message', 'Artikal je uspješno izbrisan');
            $this->dispatch('MenuItemDeleted');
        }

        $this->closeModal();
    }
    public function render()
    {
        return view('livewire.admin.menu-delete-item');
    }
}
