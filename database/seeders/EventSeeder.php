<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'name' => 'Petak Party Night',
                'description' => 'Uživajte u energičnom petku uz DJ-a i specijalna pića.',
                'price' => 0,
                'date' => now()->addDays(2)->setTime(21, 0),
                'status' => 'active',
                'image' => 'images/events/petak-party.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Subota Live Band',
                'description' => 'Nastup lokalnog benda uz dobru atmosferu i društvo.',
                'price' => 0,
                'date' => now()->addDays(3)->setTime(21, 0),
                'status' => 'active',
                'image' => 'images/events/subota-live.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Retro Veče',
                'description' => 'Veče retro muzike 80-ih i 90-ih, specijalna ponuda koktela.',
                'price' => 10,
                'date' => now()->addDays(9)->setTime(21, 0),
                'status' => 'inactive',
                'image' => 'images/events/retro.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vesna Zmijanac - Gala Night',
                'description' => 'Poseban nastup Vesne Zmijanac uz rezervacije stolova i catering.',
                'price' => 20,
                'date' => now()->addDays(16)->setTime(21, 0),
                'status' => 'inactive',
                'image' => 'images/events/vesna-zmijanac.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Event::insert($events);
    }
}
