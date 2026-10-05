<?php

namespace App\Http\Controllers;

use App\Models\NewsletterContact;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        NewsletterContact::firstOrCreate(['email' => strtolower(trim($validated['email']))]);

        return back()->with('message', 'Uspješno ste se prijavili na naš fun base. Hvala, javimo se uskoro.');
    }
}
