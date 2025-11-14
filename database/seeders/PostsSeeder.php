<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Kako postići bolju organizaciju rada?',
                'body' => 'Ovo je tekst za post broj 1.',
                'image' => 'images/pub.png',
                'excerpt' => 'Ovo je tek kratki opis',
            ],
            [
                'title' => 'Kako bolje iskoristiti prostor?',
                'body' => 'Ovo je tekst za post broj 2.',
                'image' => 'images/pub.png',
                'excerpt' => 'Ovo je tek kratki opis',
            ],
            [
                'title' => 'Zašto posao stagnira?',
                'body' => 'Ovo je tekst za post broj 3.',
                'image' => 'images/pub.png',
                'excerpt' => 'Ovo je tek kratki opis',
            ],
            [
                'title' => 'Kako da gosti budu zadovoljni?',
                'body' => 'Ovo je tekst za post broj 4.',
                'image' => 'images/pub.png',
                'excerpt' => 'Ovo je tek kratki opis',
            ],
        ];

        Post::insert($posts);
    }
}
