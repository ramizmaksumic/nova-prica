<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class PostDelete extends ModalComponent
{

    public $postId;

    public function mount($postId)
    {
        $this->postId = $postId;
    }

    public function delete()
    {
        $post = Post::findOrFail($this->postId);

        if ($post) {
            $post->delete();
            session()->flash('message', 'Post je upsješno izbrisan.');
            $this->dispatch('postDeleted');
        }

        $this->closeModal();
    }
    public function render()
    {
        return view('livewire.admin.post-delete');
    }
}
