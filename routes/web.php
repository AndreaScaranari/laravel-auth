<?php

use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Guest\HomeController as GuestHomeController;
use App\Http\Controllers\Admin\PostController as AdminPostController;;
use App\Http\Controllers\Guest\PostController as GuestPostController;;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', GuestHomeController::class)->name('guest.home');
Route::get('/posts/{slug}', [GuestPostController::class, 'show'])->name('guest.post.show');


Route::prefix('/admin')->name('admin.')->middleware('auth')->group(function(){
    
    Route::get('', AdminHomeController::class)->name('home');
    
    Route::get('/posts/trash', [AdminPostController::class, 'trash'])->name('posts.trash');
    Route::patch('/posts/{post}/restore', [AdminPostController::class, 'restore'])->name('posts.restore')->withTrashed();
    Route::patch('/posts/{post}/drop', [AdminPostController::class, 'drop'])->name('posts.drop')->withTrashed();

    Route::resource('posts', AdminPostController::class)->withTrashed(['show', 'edit', 'update']);
    
    // Route::get('/posts', [PostController::class, 'index'])->name('post.index');
    // Route::get('/posts/create', [PostController::class, 'create'])->name('post.create');
    // Route::get('/posts/{post}', [PostController::class, 'show'])->name('post.show');
    // Route::post('/posts', [PostController::class, 'store'])->name('post.store');
    // Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
    // Route::put('/posts/{post}', [PostController::class, 'update'])->name('post.update');
    // Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('post.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
