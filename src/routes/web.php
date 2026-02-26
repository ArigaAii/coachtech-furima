<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseAddressController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ItemCommentController;



Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('items.show');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {

    $request->fulfill();

    $user = $request->user();

    // プロフィール未完了ならプロフィールへ
    if (! $user->profile_completed) {
        return redirect()->route('mypage.profile.edit');
    }

    return redirect()->route('items.index');

})->middleware(['auth', 'signed'])->name('verification.verify');

// メール認証・「プロフィール完了」が必要なページ（売る/買う/マイページ等）はここ
Route::middleware(['auth', 'verified', 'profile.completed'])->group(function () {
    // 出品
    Route::get('/sell', [SellController::class, 'create'])->name('sell.create');
    Route::post('/sell', [SellController::class, 'store'])->name('sell.store');

     // 購入
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/purchase/{item_id}/checkout', [PurchaseController::class, 'checkout'])->name('purchase.checkout');
    Route::get('/purchase/{item_id}/success', [PurchaseController::class, 'success'])->name('purchase.success');
    Route::get('/purchase/{item_id}/cancel', [PurchaseController::class, 'cancel'])->name('purchase.cancel');

    // 配送先変更
    Route::get('/purchase/address/{item_id}', [PurchaseAddressController::class, 'edit'])->name('purchase.address.edit');
    Route::post('/purchase/address/{item_id}', [PurchaseAddressController::class, 'update'])->name('purchase.address.update');

    //マイページ
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');
});

// メール認証が終わった人だけ「プロフィール初回設定」に進める
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mypage/profile', [MypageController::class, 'edit'])->name('mypage.profile.edit');
    Route::post('/mypage/profile', [MypageController::class, 'update'])->name('mypage.profile.update');
    //Route::post('/item/{item_id}/comments', [CommentController::class, 'store'])->name('items.comments.store');
});


// ログイン必須（購入・コメント・いいね）
Route::middleware('auth')->group(function () {
    //いいね
    Route::post('/item/{item}/like', [LikeController::class, 'toggle'])->name('items.like');

    //コメント
    Route::post('/item/{item}/comments', [ItemCommentController::class, 'store'])
        ->name('items.comments.store');

    Route::get('/mypage/profile', [MypageController::class, 'edit'])->name('mypage.profile.edit');
    Route::post('/mypage/profile', [MypageController::class, 'update'])->name('mypage.profile.update');
});