<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;




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







Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';




use App\Http\Controllers\Auth\SocialController;

Route::get('/auth/google', [SocialController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [SocialController::class, 'handleGoogleCallback']);
Route::get('/auth/facebook', [SocialController::class, 'redirectToFacebook']);
Route::get('/auth/facebook/callback', [SocialController::class, 'handleFacebookCallback']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('auth.dashboard');
    })->name('dashboard');

    Route::get('/profile/edit', function () {
        return view('auth.edit-profile');
    })->name('profile.edit');
    
    Route::post('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});












// gallery details

Route::get('/gallery/event-{id}', function ($id) {
    $events = [
        1 => ['title' => 'Book Fair 2025', 'images' => ['a1.png', 'a2.png', 'a3.png', 'a4.png', 'a5.png']],
        2 => ['title' => 'Art Exhibition', 'images' => ['b1.png', 'b2.png', 'b3.png', 'b4.png' , 'b5.png']],
        3 => ['title' => 'Tech Conference', 'images' => ['c1.png', 'c2.png', 'c3.png', 'c4.png' , 'c5.png']],
        4 => ['title' => 'Food Carnival', 'images' => ['d1.png', 'd2.png', 'd3.png', 'd4.png']],
        5 => ['title' => 'Film Night', 'images' => ['film1.jpg', 'film2.jpg']],
        6 => ['title' => 'Startup Meetup', 'images' => ['startup1.jpg', 'startup2.jpg']],
        7 => ['title' => 'Book Fair', 'images' => ['book1.jpg', 'book2.jpg']],
        8 => ['title' => 'Dance Show', 'images' => ['dance1.jpg', 'dance2.jpg']],
        9 => ['title' => 'Drama Performance', 'images' => ['drama1.jpg', 'drama2.jpg']],
        10 => ['title' => 'Fashion Gala', 'images' => ['fashion1.jpg', 'fashion2.jpg']],
        11 => ['title' => 'Science Fair', 'images' => ['science1.jpg', 'science2.jpg']],
        12 => ['title' => 'Photography Expo', 'images' => ['photo1.jpg', 'photo2.jpg']],
        13 => ['title' => 'Cultural Day', 'images' => ['cultural1.jpg', 'cultural2.jpg']],
        14 => ['title' => 'Charity Concert', 'images' => ['charity1.jpg', 'charity2.jpg']],
    ];

    if (!array_key_exists($id, $events)) {
        abort(404);
    }

    return view('gallery-details', $events[$id]);
});
