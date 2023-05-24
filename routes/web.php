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

Route::fallback(function () {
    return redirect()->route('deal.list');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('deal')->group(function () {
    Route::get('', [\App\Http\Controllers\DealController::class, 'list'])->name('deal.list');
    Route::get('/{deal}', [\App\Http\Controllers\DealController::class, 'view'])->name('deal.view')->whereNumber('deal');
    Route::get('/create', [\App\Http\Controllers\DealController::class, 'store'])->name('deal.create');
    Route::post('/create', [\App\Http\Controllers\DealController::class, 'create']);
    Route::get('/{deal}/edit', [\App\Http\Controllers\DealController::class, 'viewEdit'])->name('deal.edit')->whereNumber('deal');
    Route::post('/{deal}/edit', [\App\Http\Controllers\DealController::class, 'edit'])->name('deal.edit')->whereNumber('deal');
    Route::get('/{deal}/approve', [\App\Http\Controllers\DealController::class, 'approve'])->name('deal.approve')->whereNumber('deal');
    Route::get('/{deal}/reject', [\App\Http\Controllers\DealController::class, 'reject'])->name('deal.reject')->whereNumber('deal');
    Route::get('/{deal}/close', [\App\Http\Controllers\DealController::class, 'close'])->name('deal.close')->whereNumber('deal');
    Route::post('/{deal}/post-reply', [\App\Http\Controllers\DealController::class, 'postReply'])->name('deal.post-reply')->whereNumber('deal');
    //Route::get('/{deal}/update-balance', [\App\Http\Controllers\DealController::class, 'updateBalance'])->name('deal.update-balance')->whereNumber('deal');
    Route::get('/{deal}/request-guarantor', [\App\Http\Controllers\DealController::class, 'viewRequestGuarantor'])->name('deal.request-guarantor')->whereNumber('deal');
    Route::post('/{deal}/request-guarantor', [\App\Http\Controllers\DealController::class, 'requestGuarantor'])->whereNumber('deal');
});

Route::prefix('message')->group(function () {
    Route::get('/deal/{deal}', [\App\Http\Controllers\DealMessageController::class, 'getDealMessages'])->name('message.deal-message')->whereNumber('deal');
    Route::get('/{message}/remove', [\App\Http\Controllers\DealMessageController::class, 'remove'])->name('message.remove')->whereNumber('message');
    Route::get('/{message}/edit', [\App\Http\Controllers\DealMessageController::class, 'viewEdit'])->name('message.edit')->whereNumber('message');
    Route::post('/{message}/edit', [\App\Http\Controllers\DealMessageController::class, 'edit'])->whereNumber('message');
});

//find
Route::post('/users/find', [\App\Http\Controllers\UserController::class, 'findUser']);

//guarantors
Route::get('/guarantors/find', [\App\Http\Controllers\GuarantorController::class, 'find']);

Route::prefix('conversation')->group(function () {
    Route::get('', [\App\Http\Controllers\ConversationController::class, 'list'])->name('conv.list')->whereAlpha('status');
    Route::get('/create', [\App\Http\Controllers\ConversationController::class, 'store'])->name('conv.create');
    Route::post('/create', [\App\Http\Controllers\ConversationController::class, 'create']);
    Route::get('/{conversation}', [\App\Http\Controllers\ConversationController::class, 'message'])->whereNumber('conversation');
    Route::post('/{conversation}/post-reply', [\App\Http\Controllers\ConversationController::class, 'postReply'])
            ->name('conv.post-reply')->whereNumber('conversation');
});

Route::prefix('profile')->group(function () {
    Route::post('/avatar', [ProfileController::class, 'avatar'])->name('profile.avatar');
    Route::get('/change-language', [ProfileController::class, 'changeLang'])->name('profile.change-language');

    Route::middleware('auth')->group(function () {
        Route::get('', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';
