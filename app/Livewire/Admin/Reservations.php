<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use \App\Models\Reservation;
use Livewire\WithPagination;

use function Laravel\Prompts\search;

class Reservations extends Component
{
    use WithPagination;

    protected $listeners = ['reservationUpdated' => '$refresh', 'reservationCreated' => 'refresh', 'reservationDeleted' => 'refresh'];


    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function render()
    {
        $search = $this->search; // ← Ovo je bitno

        $reservations = Reservation::with(['event', 'user', 'table'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->whereHas(
                        'event',
                        fn($q) =>
                        $q->where('name', 'like', "%{$search}%")
                    )
                        ->orWhereHas(
                            'user',
                            fn($q) =>
                            $q->where('name', 'like', "%{$search}%")
                        )
                        ->orWhereHas(
                            'table',
                            fn($q) =>
                            $q->where('name', 'like', "%{$search}%")
                        );
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.reservation', compact('reservations'))
            ->extends('admin.dashboard')
            ->section('content');
    }

    public function downloadPdf()
    {
        $search = $this->search;

        // iste rezervacije koje se prikazuju u tabeli
        $reservations = Reservation::with(['event', 'user', 'table'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->whereHas('event', fn($q) => $q->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('table', fn($q) => $q->where('name', 'like', "%{$search}%"));
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // render HTML u PDF
        $html = view('admin.pdf.reservations', compact('reservations'))->render();

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response()->streamDownload(function () use ($dompdf) {
            echo $dompdf->output();
        }, 'rezervacije.pdf');
    }
}
