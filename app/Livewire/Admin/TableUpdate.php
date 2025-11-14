<?php

namespace App\Livewire\Admin;

use App\Models\Table;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class TableUpdate extends ModalComponent
{

    public $tableId;
    public $name;
    public $min_capacity;
    public $max_capacity;
    public $description;
    public $is_reserved;

    public function mount($tableId)
    {
        $table = Table::findOrFail($tableId);

        $this->tableId = $table->id;
        $this->name = $table->name;
        $this->min_capacity = $table->min_capacity;
        $this->max_capacity = $table->max_capacity;
        $this->description = $table->description;
        $this->is_reserved = $table->is_reserved;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'min_capacity' => 'required|integer|min:2|',
            'max_capacity' => 'required|integer|max:8',
            'description' => 'nullable|string|max:255',
            'is_reserved' => 'string'
        ]);

        $table = Table::findOrFail($this->tableId);
        $table->update([
            'name' => $this->name,
            'min_capacity' => $this->min_capacity,
            'max_capacity' => $this->max_capacity,
            'description' => $this->description,
            'is_reserved' => $this->is_reserved,
        ]);
        $this->dispatch('tableUpdated');
        $this->closeModal();
    }


    public function render()
    {
        return view('livewire.admin.table-update');
    }
}
