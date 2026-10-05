<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Post;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $urls = collect([
            ['loc' => route('home'), 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => route('events'), 'changefreq' => 'daily', 'priority' => '0.9'],
            ['loc' => route('menu'), 'changefreq' => 'weekly', 'priority' => '0.7'],
            ['loc' => route('about-us'), 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => route('contact'), 'changefreq' => 'monthly', 'priority' => '0.5'],
        ]);

        Event::active()->orderByDesc('date')->limit(500)->get(['id', 'updated_at'])
            ->each(fn ($event) => $urls->push([
                'loc' => route('event.detail', $event),
                'lastmod' => $event->updated_at?->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ]));

        Post::latest()->limit(500)->get(['id', 'updated_at'])
            ->each(fn ($post) => $urls->push([
                'loc' => route('post.show', $post),
                'lastmod' => $post->updated_at?->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ]));

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
