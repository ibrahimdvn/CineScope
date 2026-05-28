<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\MovieController;

Auth::routes();

Route::get('/', [MovieController::class, 'index'])->name('movies.index');
Route::get('/search', [MovieController::class, 'search'])->name('movies.search');
Route::get('/movie/{id}', [MovieController::class, 'show'])->name('movies.show');
Route::get('/now-playing', [MovieController::class, 'nowPlaying'])->name('movies.now_playing');

use App\Http\Controllers\PagesController;
Route::get('/hakkimizda', [PagesController::class, 'about'])->name('pages.about');
Route::get('/iletisim', [PagesController::class, 'contact'])->name('pages.contact');
Route::get('/kullanim-kosullari', [PagesController::class, 'terms'])->name('pages.terms');
Route::get('/gizlilik-politikasi', [PagesController::class, 'privacy'])->name('pages.privacy');
Route::get('/cerez-politikasi', [PagesController::class, 'cookies'])->name('pages.cookies');

Route::middleware(['auth'])->group(function () {
    Route::get('/favorites', [MovieController::class, 'favorites'])->name('movies.favorites');
    Route::post('/favorites/toggle', [MovieController::class, 'toggleFavorite'])->name('movies.toggleFavorite');
});

// Admin Panel Routes
use App\Http\Controllers\AdminController;
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    
    Route::middleware(['admin.auth'])->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/movies', [AdminController::class, 'movies'])->name('admin.movies');
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    });
});
