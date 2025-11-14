<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Livewire\Admin\Events;
use App\Livewire\Admin\Posts;
use App\Livewire\Admin\Reservations;
use App\Livewire\Admin\Tables;
use App\Livewire\AdminDashboard;
use App\Models\Event;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Livewire\Admin\Menus;


Route::get('/', function () {

    $events = Event::where('status', 'active')->take(4)->get();
    $posts = Post::latest()->take(4)->get();
    return view('home', compact('events', 'posts'));
});

Route::get('/o-namam', function () {
    return view('about-us');
})->name('about-us');

Route::get('/events', [EventController::class, 'index'])->name('events');
Route::get('/events/{event}', [EventController::class, 'detail'])->name('event.detail');

Route::get('/post/{post}', [PostController::class, 'show'])->name('post.show');

Route::get('meni/', function () {
    return view('menu');
})->name('menu');

Route::get('/kontatk', [ContactController::class, 'index'])->name('contact');


Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/events', Events::class)->name('admin.events');
    Route::get('/reservations', Reservations::class)->name('admin.reservations');
    Route::get('/tables', Tables::class)->name('admin.tables');
    Route::get('/posts', Posts::class)->name('admin.posts');
    Route::get('/menu', Menus::class)->name('admin.menus');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/reservations', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{reservation}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('/reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
});


Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('admin', [AdminController::class, 'index'])->name('admin.dashboard');
});

require __DIR__ . '/auth.php';
