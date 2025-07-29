<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AddressController;


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

Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::get('/', [ProductController::class, 'index'])
    ->name('products.index');

Route::post('/products', [ProductController::class, 'store'])
    ->name('products.store')
    ->middleware('auth');

Route::get('/products/create', [ProductController::class, 'create'])
->middleware(['auth', 'verified'])
->name('products.create');

require __DIR__.'/auth.php';

//商品詳細画面を表示
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::post('/products/{product}/comment', [CommentController::class, 'store'])->name('products.comment')
->middleware('auth');

Route::post('/products/{product}/like', [LikeController::class, 'toggle'])->name('products.like')
->middleware('auth');

Route::post('/purchase/{product}/complete', [PurchaseController::class, 'complete'])
    ->name('purchase.complete');

// 購入ページ
Route::get('/purchase/{product}', [PurchaseController::class, 'index'])
    ->name('purchase.index')
    ->middleware(['auth']);

// 認証されていればアクセスできる（初回プロフィール設定用）
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/setup', [ProfileController::class, 'setup'])->name('profile.setup');
    Route::post('/profile/setup', [ProfileController::class, 'storeSetup'])->name('profile.storeSetup');
});

// プロフィールが設定済みのユーザーのみアクセス可能にする（マイページなど）
Route::middleware(['auth', 'profile.setup'])->group(function () {
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');

    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/profile/address/edit', [ProfileController::class, 'editAddress'])->name('profile.editAddress');

    Route::middleware(['auth'])->group(function () {
        Route::get('/address/edit', [AddressController::class, 'edit'])->name('address.edit');
        Route::put('/address/update', [AddressController::class, 'update'])->name('address.update');
    });
});