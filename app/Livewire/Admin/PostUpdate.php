<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class PostUpdate extends ModalComponent
{
    use WithFileUploads;

    public $postId;
    public $title;
    public $body;
    public $image;
    public $newImage; // uploaded file
    public $excerpt;

    public function mount($postId)
    {
        $post = Post::findOrFail($postId);

        $this->postId = $post->id;
        $this->title = $post->title;
        $this->body = $post->body;
        $this->image = $post->image;
        $this->excerpt = $post->excerpt;
    }

    public function update()
    {
        $validated = $this->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:5000',
            'newImage' => 'nullable|image|max:2048',
            'excerpt' => 'string|nullable',
        ]);

        if ($this->newImage) {
            $validated['image'] = $this->newImage->store('posts', 'public');
        } else {
            // ako nema nove → koristi staru
            $validated['image'] = $this->image;
        }

        $post = Post::findOrFail($this->postId);
        $post->update($validated);

        $this->closeModal();
        $this->dispatch('postUpdated');
    }

    public function render()
    {
        return view('livewire.admin.post-update');
    }
}
