<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\RequiresAdmin;
use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class UserDelete extends ModalComponent
{
    use RequiresAdmin;
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
        if ($this->userId === auth()->id()) {
            $this->addError('delete', 'Ne možete obrisati vlastiti nalog.');
            return;
        }

        $user = User::findOrFail($this->userId);

        // Rezervacije korisnika se brišu kaskadno (foreign key), čime se oslobađaju i stolovi.
        $user->delete();

        $this->dispatch('userDeleted');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.user-delete');
    }
}
