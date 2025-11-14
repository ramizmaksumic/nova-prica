<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use App\Models\Table;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class TableCreate extends ModalComponent
{

    public $name;
    public $min_capacity;
    public $max_capacity;
    public $description;
    public $is_reserved;

    public function save()
    {

        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'min_capacity' => 'required|integer|min:2',
            'max_capacity' => 'required|integer|max:8',
            'description' => 'nullable|string|max:255',
            'is_reserved' => 'nullable|string|max:1',
        ]);

        $table = Table::create($validated);

        $this->dispatch('tableCreated');
        $this->closeModal();
    }
    public function render()
    {
        return view('livewire.admin.table-create');
    }
}
