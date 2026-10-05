<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\RequiresAdmin;
use App\Models\Table;
use LivewireUI\Modal\ModalComponent;

class TableCreate extends ModalComponent
{
    use RequiresAdmin;

    public $name;
    public $min_capacity;
    public $max_capacity;
    public $description;

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'min_capacity' => 'required|integer|min:1|max:30',
            'max_capacity' => 'required|integer|max:30|gte:min_capacity',
            'description' => 'nullable|string|max:255',
        ]);

        $validated['description'] ??= '';

        Table::create($validated);

        $this->dispatch('tableCreated');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.table-create');
    }
}
