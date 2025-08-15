<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlogController;

// navbar pages routes
Route::get('/', function () {
    return view('home');
});
Route::get('/events', function () {
    return view('events');
});
Route::get('/gallery', function () {
    return view('gallery');
});
Route::get('/blog', function () {
    return view('blog');
});
Route::get('/contact', function () {
    return view('contact');
});

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// dashboard routes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';




use App\Http\Controllers\TicketController;

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');




Route::middleware('auth')->group(function () {
    Route::get('/events/{event}/buy', [TicketController::class, 'buy'])->name('events.buy');
    Route::post('/events/{event}/checkout', [TicketController::class, 'checkout'])->name('events.checkout');

    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
});




// Auth Routes
Route::get('/auth/google', [SocialController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [SocialController::class, 'handleGoogleCallback']);

Route::get('/auth/facebook', [SocialController::class, 'redirectToFacebook']);
Route::get('/auth/facebook/callback', [SocialController::class, 'handleFacebookCallback']);

Route::post('/login', [AuthController::class, 'login'])->name('login.custom');
Route::post('/register', [AuthController::class, 'register'])->name('register.custom');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// Routes for blog pages
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show');

// gallery details routes
Route::get('/gallery/event-{id}', function ($id) {
    $events = [
        1 => ['title' => 'Book Fair 2025', 'images' => ['a1.png', 'a2.png', 'a3.png', 'a4.png', 'a5.png']],
        2 => ['title' => 'Art Exhibition', 'images' => ['b1.png', 'b2.png', 'b3.png', 'b4.png', 'b5.png']],
        3 => ['title' => 'Tech Conference', 'images' => ['c1.png', 'c2.png', 'c3.png', 'c4.png', 'c5.png']],
        4 => ['title' => 'Food Carnival', 'images' => ['d1.png', 'd2.png', 'd3.png', 'd4.png']],
        5 => ['title' => 'Film Night', 'images' => ['e1.png', 'e2.png', 'e3.png', 'e4.png']],
        6 => ['title' => 'Startup Meetup', 'images' => ['f1.png', 'f2.png', 'f3.png', 'f4.png', 'f5.png']],
        7 => ['title' => 'Book Fair', 'images' => ['g1.png', 'g2.png', 'g3.png', 'g4.png', 'g5.png']],
        8 => ['title' => 'Dance Show', 'images' => ['h1.png', 'h2.png', 'h3.png', 'h4.png', 'h5.png']],
        9 => ['title' => 'Drama Performance', 'images' => ['i1.png', 'i2.png', 'i3.png', 'i4.png', 'i5.png']],
        10 => ['title' => 'Fashion Gala', 'images' => ['fashion1.png', 'fashion2.png']],
        11 => ['title' => 'Science Fair', 'images' => ['science1.png', 'science2.png']],
        12 => ['title' => 'Photography Expo', 'images' => ['photo1.png', 'photo2.png']],
        13 => ['title' => 'Cultural Day', 'images' => ['cultural1.png', 'cultural2.png']],
        14 => ['title' => 'Charity Concert', 'images' => ['charity1.jpg', 'charity2.jpg']],
    ];

    if (!array_key_exists($id, $events)) {
        abort(404);
    }

    return view('gallery-details', $events[$id]);
});
