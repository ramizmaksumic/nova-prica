<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\RequiresAdmin;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Posts extends Component
{
    use RequiresAdmin;
    use WithPagination;

    protected $listeners = ['postCreated' => '$refresh', 'postUpdated' => '$refresh', 'postDeleted' => '$refresh'];
    public function render()
    {

        $posts = Post::latest()->paginate(10);
        return view('livewire.admin.posts', compact('posts'))->extends('admin.dashboard')->section('content');
    }
}
