<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{

    use WithPagination;

    protected $listeners = ['userDeleted' => 'refresh', 'userUpdated' => 'refresh'];


    public function render()
    {

        $users = User::paginate(10);
        return view('livewire.admin.users', compact('users'))->extends('admin.dashboard')->section('content');
    }
}
