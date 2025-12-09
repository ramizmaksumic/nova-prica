<?php

namespace App\Livewire\Admin;

use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class UserDelete extends ModalComponent
{
    public $userId;
    public $name;

    public function mount($userId)
    {
        $user = User::findOrFail($userId);

        $this->userId = $user->id;
        $this->name = $user->name;
    }

    public function delete()
    {
        $user = User::findOrFail($this->userId);

        // Ako želiš da se obrišu i rezervacije korisnika (opciono)
        // $user->reservations()->delete();

        $user->delete();

        $this->dispatch('userDeleted');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.user-delete');
    }
}
