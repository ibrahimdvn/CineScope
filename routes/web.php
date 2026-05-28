<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Rotaları
|--------------------------------------------------------------------------
|
| Burada uygulamanız için web rotalarını kaydedebilirsiniz. Bu
| rotalar, "web" ara yazılım grubunu içeren bir grup içinde
| RouteServiceProvider tarafından yüklenir. Şimdi harika bir şey oluşturun!
|
*/

use App\Http\Controllers\MovieController;

Auth::routes();

Route::get('/', [MovieController::class, 'index'])->name('movies.index');
Route::get('/ajax-search', [MovieController::class, 'ajaxSearch'])->name('movies.ajaxSearch');
Route::get('/search', [MovieController::class, 'search'])->name('movies.search');
Route::get('/movie/{id}', [MovieController::class, 'show'])->name('movies.show');
Route::get('/now-playing', [MovieController::class, 'nowPlaying'])->name('movies.now_playing');

// Dizi/TV Rotaları
Route::get('/tv', [MovieController::class, 'tvIndex'])->name('tv.index');
Route::get('/tv/{id}', [MovieController::class, 'tvShow'])->name('tv.show');

use App\Http\Controllers\PagesController;
Route::get('/hakkimizda', [PagesController::class, 'about'])->name('pages.about');
Route::get('/iletisim', [PagesController::class, 'contact'])->name('pages.contact');
Route::get('/kullanim-kosullari', [PagesController::class, 'terms'])->name('pages.terms');
Route::get('/gizlilik-politikasi', [PagesController::class, 'privacy'])->name('pages.privacy');
Route::get('/cerez-politikasi', [PagesController::class, 'cookies'])->name('pages.cookies');
Route::get('/destek', [PagesController::class, 'support'])->name('pages.support');

Route::get('/forum', [\App\Http\Controllers\PostController::class, 'index'])->name('forum.index');

Route::middleware(['auth'])->group(function () {
    Route::post('/forum', [\App\Http\Controllers\PostController::class, 'store'])->name('forum.store');
    Route::post('/forum/{post}/like', [\App\Http\Controllers\PostController::class, 'toggleLike'])->name('forum.like');
    Route::post('/forum/{post}/comment', [\App\Http\Controllers\PostController::class, 'storeComment'])->name('forum.comment');
    Route::delete('/forum/{post}', [\App\Http\Controllers\PostController::class, 'destroy'])->name('forum.destroy');

    Route::get('/bildirimler', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/bildirimler/unread', [\App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('notifications.unread');

    Route::get('/favorites', [MovieController::class, 'favorites'])->name('movies.favorites');
    Route::post('/favorites/toggle', [MovieController::class, 'toggleFavorite'])->name('movies.toggleFavorite');
    
    // Profil Rotaları
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

// Herkese Açık Profil Rotası
Route::get('/user/{id}', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');

// Yönetici (Admin) Paneli Rotaları
use App\Http\Controllers\AdminController;
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    
    Route::middleware(['admin.auth'])->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
    });
});
