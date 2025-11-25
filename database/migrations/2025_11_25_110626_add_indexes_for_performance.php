<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            if (! $this->indexExists('reservations', 'reservations_event_id_index')) {
                $table->index('event_id');
            }
            if (! $this->indexExists('reservations', 'reservations_table_id_index')) {
                $table->index('table_id');
            }
            if (! $this->indexExists('reservations', 'reservations_user_id_index')) {
                $table->index('user_id');
            }
            if (! $this->indexExists('reservations', 'reservations_status_index')) {
                $table->index('status');
            }
        });

        Schema::table('events', function (Blueprint $table) {
            if (! $this->indexExists('events', 'events_status_index')) {
                $table->index('status');
            }
        });

        Schema::table('menu_items', function (Blueprint $table) {
            if (! $this->indexExists('menu_items', 'menu_items_menu_category_id_index')) {
                $table->index('menu_category_id');
            }
        });
    }

    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropIndex('reservations_event_id_index');
            $table->dropIndex('reservations_table_id_index');
            $table->dropIndex('reservations_user_id_index');
            $table->dropIndex('reservations_status_index');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex('events_status_index');
        });

        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropIndex('menu_items_menu_category_id_index');
        });
    }

    private function indexExists(string $table, string $indexName): bool
    {
        return collect(\DB::select("SHOW INDEX FROM `$table`"))
            ->pluck('Key_name')
            ->contains($indexName);
    }
};
