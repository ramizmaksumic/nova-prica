<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Validacija dozvoljava 5000 znakova, a string kolona prima samo 255.
            $table->text('description')->nullable()->change();
            // unsignedTinyInteger je ograničavao cijenu na 255 KM.
            $table->unsignedSmallInteger('price')->nullable()->change();
            $table->index(['status', 'date'], 'events_status_date_index');
        });

        // Zauzetost stola se računa po događaju iz tabele reservations; globalni flag je pogrešan.
        if (Schema::hasColumn('tables', 'is_reserved')) {
            Schema::table('tables', function (Blueprint $table) {
                $table->dropColumn('is_reserved');
            });
        }

        // Google prijava ne daje uvijek prezime.
        Schema::table('users', function (Blueprint $table) {
            $table->string('surname')->nullable()->change();
        });

        // Ukloni duple newsletter emailove prije unique indeksa.
        $keepIds = DB::table('newsletter_contacts')
            ->selectRaw('MIN(id) as id')
            ->groupBy('email')
            ->pluck('id');
        DB::table('newsletter_contacts')->whereNotIn('id', $keepIds)->delete();

        Schema::table('newsletter_contacts', function (Blueprint $table) {
            $table->unique('email');
        });
    }

    public function down(): void
    {
        Schema::table('newsletter_contacts', function (Blueprint $table) {
            $table->dropUnique(['email']);
        });

        Schema::table('tables', function (Blueprint $table) {
            $table->boolean('is_reserved')->default(false);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex('events_status_date_index');
        });
    }
};
