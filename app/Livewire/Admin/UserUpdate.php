<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\RequiresAdmin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class UserUpdate extends ModalComponent
{
    use RequiresAdmin;

    use WithFileUploads;

    public $userId;
    public $name;
    public $surname;
    public $email;
    public $phone;
    public $role;
    public $image;
    public $existingImage;
    public $password; // OPTIONAL password reset

    public function mount($userId)
    {
        $user = User::findOrFail($userId);

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->surname = $user->surname;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->role = $user->role;
        $this->existingImage = $user->image;
    }

    public function update()
    {
        $validated = $this->validate([
            'name'  => 'required|string|max:255',
            'surname'  => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->userId,
            'phone' => 'nullable|string|max:25|unique:users,phone,' . $this->userId,
            'role' => 'required|in:user,admin',
            'image' => 'nullable|image|max:2048',
            'password' => 'nullable|string|min:8'
        ]);

        // Admin ne može sam sebi oduzeti admin pristup (da ne ostane bez pristupa panelu).
        if ($this->userId === auth()->id() && $validated['role'] !== 'admin') {
            $this->addError('role', 'Ne možete sami sebi ukloniti admin ovlaštenje.');
            return;
        }

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

        // role nije mass-assignable (zaštita od podizanja privilegija), postavlja se eksplicitno.
        $role = $validated['role'];
        unset($validated['role']);

        $user->fill($validated);
        $user->role = $role;
        $user->save();

        $this->dispatch('userUpdated');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.user-update');
    }
}
