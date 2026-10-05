<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\RequiresAdmin;
use App\Models\Table;
use LivewireUI\Modal\ModalComponent;

class TableUpdate extends ModalComponent
{
    use RequiresAdmin;

    public $tableId;
    public $name;
    public $min_capacity;
    public $max_capacity;
    public $description;

    public function mount($tableId)
    {
        $table = Table::findOrFail($tableId);

        $this->tableId = $table->id;
        $this->name = $table->name;
        $this->min_capacity = $table->min_capacity;
        $this->max_capacity = $table->max_capacity;
        $this->description = $table->description;
    }

    public function update()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'min_capacity' => 'required|integer|min:1|max:30',
            'max_capacity' => 'required|integer|max:30|gte:min_capacity',
            'description' => 'nullable|string|max:255',
        ]);

        $validated['description'] ??= '';

        Table::findOrFail($this->tableId)->update($validated);

        $this->dispatch('tableUpdated');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.table-update');
    }
}
