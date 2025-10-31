<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tables = [];

        for ($i = 1; $i <= 89; $i++) {
            $tables[] = [
                'name' => 'Stol ' . $i,
                'min_capacity' => 2,
                'max_capacity' => 4,
                'description' => 'Standardni sto za 2 do 4 osobe.',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Table::insert($tables);
    }
}
