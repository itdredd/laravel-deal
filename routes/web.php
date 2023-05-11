<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return redirect('/deal');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/deal', [\App\Http\Controllers\DealController::class, 'list'])->name('deal.list')->whereAlpha('status');
Route::get('/test', [\App\Http\Controllers\DealController::class, 'test']);
Route::get('/deal/{deal}', [\App\Http\Controllers\DealController::class, 'view'])->name('deal.view')->whereNumber('deal');
Route::get('/deal/create', [\App\Http\Controllers\DealController::class, 'store'])->name('deal.create');
Route::post('/deal/create', [\App\Http\Controllers\DealController::class, 'create']);
Route::get('/deal/{deal}/edit', [\App\Http\Controllers\DealController::class, 'viewEdit'])->name('deal.edit')->whereNumber('deal');
Route::post('/deal/{deal}/edit', [\App\Http\Controllers\DealController::class, 'edit'])->name('deal.edit')->whereNumber('deal');
Route::get('/deal/{deal}/approve', [\App\Http\Controllers\DealController::class, 'approve'])->name('deal.approve')->whereNumber('deal');
Route::get('/deal/{deal}/reject', [\App\Http\Controllers\DealController::class, 'reject'])->name('deal.reject')->whereNumber('deal');
Route::get('/deal/{deal}/close', [\App\Http\Controllers\DealController::class, 'close'])->name('deal.close')->whereNumber('deal');
Route::post('/deal/{deal}/post-reply', [\App\Http\Controllers\DealController::class, 'postReply'])->name('deal.post-reply')->whereNumber('deal');
//Route::get('/deal/{deal}/update-balance', [\App\Http\Controllers\DealController::class, 'updateBalance'])->name('deal.update-balance')->whereNumber('deal');

Route::get('/message/deal/{deal}', [\App\Http\Controllers\MessageController::class, 'getDealMessages'])->name('message.deal-message')->whereNumber('deal');
Route::get('/message/{message}/remove', [\App\Http\Controllers\MessageController::class, 'remove'])->name('message.remove')->whereNumber('message');
Route::get('/message/{message}/edit', [\App\Http\Controllers\MessageController::class, 'viewEdit'])->name('message.edit')->whereNumber('message');
Route::post('/message/{message}/edit', [\App\Http\Controllers\MessageController::class, 'edit'])->whereNumber('message');

//find
Route::get('/users/find', [\App\Http\Controllers\UserController::class, 'store'])->name('users.find');
Route::post('/users/find', [\App\Http\Controllers\UserController::class, 'findUser']);


Route::get('/guarantors/find', [\App\Http\Controllers\GuarantorController::class, 'find']);


//profile
Route::post('/profile/avatar', [ProfileController::class, 'avatar'])->name('profile.avatar');
Route::get('/profile/change-language', [ProfileController::class, 'changeLang'])->name('profile.change-language');

require __DIR__.'/auth.php';
