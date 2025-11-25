<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class Users extends Component
{
    public function render()
    {

        $users = User::paginate(10);
        return view('livewire.admin.users', compact('users'))->extends('admin.dashboard')->section('content');
    }
}
