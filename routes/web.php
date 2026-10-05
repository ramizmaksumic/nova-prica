<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SitemapController;
use App\Livewire\Admin\Contacts;
use App\Livewire\Admin\Events;
use App\Livewire\Admin\Menus;
use App\Livewire\Admin\Posts;
use App\Livewire\Admin\Reservations;
use App\Livewire\Admin\Tables;
use App\Livewire\Admin\Users;
use App\Livewire\AdminDashboard;
use App\Models\Event;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $events = Event::upcoming()->take(4)->get();

    $posts = Post::latest()->take(4)->get();
    return view('home', compact('events', 'posts'));
})->name('home');

Route::view('/o-nama', 'about-us')->name('about-us');

Route::get('/events', [EventController::class, 'index'])->name('events');
Route::get('/events/{event}', [EventController::class, 'detail'])->name('event.detail');

Route::get('/post/{post}', [PostController::class, 'show'])->name('post.show');

Route::view('/meni', 'menu')->name('menu');

Route::get('/kontakt', [ContactController::class, 'index'])->name('contact');

// Stari URL-ovi s greškom u kucanju — trajno preusmjeravanje da Google prenese indeksiranje.
Route::permanentRedirect('/o-namam', '/o-nama');
Route::permanentRedirect('/kontatk', '/kontakt');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

Route::post('newsletter', [NewsletterController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('newsletter.store');


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::redirect('/admin', '/admin/dashboard');

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', AdminDashboard::class)->name('admin.dashboard');
        Route::get('/events', Events::class)->name('admin.events');
        Route::get('/reservations', Reservations::class)->name('admin.reservations');
        Route::get('/tables', Tables::class)->name('admin.tables');
        Route::get('/posts', Posts::class)->name('admin.posts');
        Route::get('/menu', Menus::class)->name('admin.menus');
        Route::get('/newsletter-contacts', Contacts::class)->name('admin.contacts');
        Route::get('/users', Users::class)->name('admin.users');
    });
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/reservations', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])
        ->middleware('throttle:10,1')
        ->name('reservations.store');
    Route::get('/reservations/{reservation}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('/reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');


require __DIR__ . '/auth.php';
