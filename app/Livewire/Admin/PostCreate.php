<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class PostCreate extends ModalComponent
{
    use WithFileUploads;

    public $title;
    public $body;
    public $image;
    public $excerpt;

    public function save()
    {
        $validated = $this->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:5000',
            'image' => 'required|image|max:2048',
            'excerpt' => 'string|nullable',
        ]);

        if ($this->image) {
            $validated['image'] = $this->image->store('posts', 'public');
        }

        Post::create($validated);

        $this->closeModal();
        $this->dispatch('postCreated');
    }

    public function render()
    {
        return view('livewire.admin.post-create');
    }
}
