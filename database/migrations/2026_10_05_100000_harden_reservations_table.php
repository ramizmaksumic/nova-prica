<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->cancelDuplicateBlockingReservations();

        Schema::table('reservations', function (Blueprint $table) {
            // Rezervacije koje admin unosi telefonom nemaju korisnički nalog.
            $table->foreignId('user_id')->nullable()->change();
            $table->string('guest_name')->nullable()->after('user_id');
            $table->string('guest_phone', 25)->nullable()->after('guest_name');

            // 1 dok rezervacija drži stol (pending/active), NULL kad je otkazana.
            // Unique indeks dozvoljava više NULL vrijednosti, pa otkazane rezervacije ne blokiraju stol,
            // a baza garantuje najviše jednu aktivnu rezervaciju po stolu za isti događaj.
            $expression = "(CASE WHEN status IN ('pending', 'active') THEN 1 ELSE NULL END)";
            if (DB::getDriverName() === 'sqlite') {
                $table->unsignedTinyInteger('active_slot')->nullable()->virtualAs($expression);
            } else {
                $table->unsignedTinyInteger('active_slot')->nullable()->storedAs($expression);
            }

            $table->unique(['event_id', 'table_id', 'active_slot'], 'reservations_one_active_per_table');
            $table->index(['event_id', 'status'], 'reservations_event_status_index');
        });

        // event_id je sada pokriven composite indeksima, a samostalni status indeks se ne koristi.
        // table_id i user_id indeksi ostaju jer ih koriste foreign key ograničenja.
        Schema::table('reservations', function (Blueprint $table) {
            foreach (['event_id', 'status'] as $column) {
                $index = "reservations_{$column}_index";
                if (Schema::hasIndex('reservations', $index)) {
                    $table->dropIndex($index);
                }
            }
        });
    }

    public function down(): void
    {
        // event_id indeks mora postojati prije brisanja composite indeksa, jer ga foreign key treba.
        Schema::table('reservations', function (Blueprint $table) {
            $table->index('event_id');
            $table->index('status');
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->dropUnique('reservations_one_active_per_table');
            $table->dropIndex('reservations_event_status_index');
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['active_slot', 'guest_name', 'guest_phone']);
        });
    }

    /**
     * Ako su u bazi već nastale duple rezervacije istog stola za isti događaj,
     * zadržava se najstarija, a novije se otkazuju (i loguju) da bi unique indeks mogao nastati.
     */
    private function cancelDuplicateBlockingReservations(): void
    {
        $duplicates = DB::table('reservations as r')
            ->join('reservations as older', function ($join) {
                $join->on('older.event_id', '=', 'r.event_id')
                    ->on('older.table_id', '=', 'r.table_id')
                    ->on('older.id', '<', 'r.id');
            })
            ->whereIn('r.status', ['pending', 'active'])
            ->whereIn('older.status', ['pending', 'active'])
            ->distinct()
            ->pluck('r.id');

        if ($duplicates->isEmpty()) {
            return;
        }

        Log::warning('Otkazane duple rezervacije prije dodavanja unique indeksa', ['ids' => $duplicates->all()]);

        DB::table('reservations')->whereIn('id', $duplicates)->update(['status' => 'cancelled']);
    }
};
