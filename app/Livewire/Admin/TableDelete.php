<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\RequiresAdmin;
use App\Models\Event;
use App\Models\Table;
use LivewireUI\Modal\ModalComponent;

class TableDelete extends ModalComponent
{
    use RequiresAdmin;

    public $tableId;
    public ?string $blockedReason = null;

    public function mount($tableId)
    {
        $this->tableId = $tableId;
    }

    public function deleteTable()
    {
        $table = Table::findOrFail($this->tableId);

        // Brisanje stola kaskadno briše i njegove rezervacije, pa se ne dozvoljava dok postoje buduće.
        $upcoming = $table->reservations()
            ->blocking()
            ->whereHas('event', fn ($q) => $q->notEnded())
            ->count();

        if ($upcoming > 0) {
            $this->blockedReason = "Stol ima {$upcoming} aktivnih rezervacija za nadolazeće događaje. Prvo ih premjestite ili otkažite.";
            return;
        }

        $table->delete();
        session()->flash('message', 'Stol je uspješno izbrisan');

        $this->dispatch('tableDeleted');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.table-delete');
    }
}
