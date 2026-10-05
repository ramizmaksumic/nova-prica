<?php

namespace App\Livewire\Concerns;

trait RequiresAdmin
{
    /**
     * Livewire poziva ovu metodu na mount i na svaki naknadni zahtjev (hydrate),
     * tako da se admin akcije ne mogu pozvati bez admin role ni direktnim Livewire requestom.
     */
    public function bootRequiresAdmin(): void
    {
        abort_unless(auth()->user()?->isAdmin(), 403);
    }
}
