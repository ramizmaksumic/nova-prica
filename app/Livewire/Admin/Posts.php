<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class Posts extends ModalComponent
{

    protected $listeners = ['postCreated' => 'refresh', 'postUpdated' => 'refresh', 'postDeleted' => 'refresh'];
    public function render()
    {

        $posts = Post::paginate(10);
        return view('livewire.admin.posts', compact('posts'))->extends('admin.dashboard')->section('content');
    }
}
