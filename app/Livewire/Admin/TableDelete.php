<?php

namespace App\Livewire\Admin;

use App\Models\Table;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class TableDelete extends ModalComponent
{

    public $tableId;

    public function mount($tableId)
    {
        $this->tableId = $tableId;
    }

    public function deleteTable()
    {

        $table = Table::findOrFail($this->tableId);

        if ($table) {
            $table->delete();
            session()->flash('message', 'Stol je uspješno izbrisan');

            $this->dispatch('tableDeleted');
            $this->closeModal();
        }
    }

    public function render()
    {
        return view('livewire.admin.table-delete');
    }
}
