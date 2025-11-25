<?php

namespace App\Livewire\Admin;

use App\Models\NewsletterContact;
use Livewire\Component;
use Livewire\WithPagination;

class Contacts extends Component
{

    use WithPagination;


    public function render()
    {

        $contacts = NewsletterContact::paginate(10);
        return view('livewire.admin.contacts', compact('contacts'))->extends('admin.dashboard')->section('content');
    }
}
