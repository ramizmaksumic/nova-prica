<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\RequiresAdmin;
use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Reservations extends Component
{
    use RequiresAdmin;

    use WithPagination;

    protected $listeners = ['reservationUpdated' => '$refresh', 'reservationCreated' => '$refresh', 'reservationDeleted' => '$refresh'];

    public $search = '';
    public $eventId = '';
    public $status = '';

    public function updating($property)
    {
        if (in_array($property, ['search', 'eventId', 'status'], true)) {
            $this->resetPage();
        }
    }

    /** Isti upit koriste tabela i PDF, da PDF uvijek odgovara onome što admin vidi. */
    private function query(): Builder
    {
        $search = trim($this->search);

        return Reservation::with(['event', 'user', 'table'])
            ->when($this->eventId, fn ($q) => $q->where('event_id', $this->eventId))
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->whereHas('event', fn ($q) => $q->where('name', 'like', "%{$search}%"))
                        ->orWhere('guest_name', 'like', "%{$search}%")
                        ->orWhere('guest_phone', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%")
                                ->orWhere('surname', 'like', "%{$search}%")
                                ->orWhere('phone', 'like', "%{$search}%")
                                ->orWhereRaw("CONCAT(name, ' ', COALESCE(surname, '')) LIKE ?", ["%{$search}%"]);
                        })
                        ->orWhereHas('table', fn ($q) => $q->where('name', 'like', "%{$search}%"));
                });
            });
    }

    public function render()
    {
        $reservations = $this->query()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('livewire.admin.reservation', [
            'reservations' => $reservations,
            'events' => Event::orderByDesc('date')->get(['id', 'name', 'date']),
        ])
            ->extends('admin.dashboard')
            ->section('content');
    }

    public function downloadPdf()
    {
        $reservations = $this->query()
            ->join('tables', 'tables.id', '=', 'reservations.table_id')
            ->orderBy('tables.name')
            ->select('reservations.*')
            ->get();

        // render HTML u PDF
        $html = view('admin.pdf.reservations', compact('reservations'))->render();

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return response()->streamDownload(function () use ($dompdf) {
            echo $dompdf->output();
        }, 'rezervacije.pdf');
    }
}
