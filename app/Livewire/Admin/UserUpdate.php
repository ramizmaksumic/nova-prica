<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class UserUpdate extends ModalComponent
{
    use WithFileUploads;

    public $userId;
    public $name;
    public $email;
    public $phone;
    public $image;
    public $existingImage;
    public $password; // OPTIONAL password reset

    public function mount($userId)
    {
        $user = User::findOrFail($userId);

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->existingImage = $user->image;
    }

    public function update()
    {
        $validated = $this->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->userId,
            'phone' => 'required|string|max:25|unique:users,phone,' . $this->userId,
            'image' => 'nullable|image|max:2048',
            'password' => 'nullable|string|min:8'
        ]);

        $user = User::findOrFail($this->userId);

        // Ako je uploadovana nova slika
        if ($this->image) {
            $validated['image'] = $this->image->store('users', 'public');
        } else {
            $validated['image'] = $this->existingImage;
        }

        // Ako admin želi resetirati lozinku
        if (!empty($this->password)) {
            $validated['password'] = Hash::make($this->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        $this->dispatch('userUpdated');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.user-update');
    }
}
