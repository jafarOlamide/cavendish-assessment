<?php

use App\Http\Controllers\Admin\AdminDeleteWebsiteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoriesContoller;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\WebsiteCategoriesController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', RegisterController::class)->name('register');
Route::post('/login', LoginController::class)->name('login');

Route::get('/categories', [CategoriesContoller::class, 'index'])->name('categories');
Route::get('/categories/websites', [WebsiteCategoriesController::class, 'index']);
Route::get('/categories/{category}/websites', [WebsiteCategoriesController::class, 'show'])->name('category.websites');

Route::get('/websites', [WebsiteController::class, 'index'])->name('website.index');
Route::post('/websites', [WebsiteController::class, 'store'])->name('website.store');
Route::post('/websites/search', [WebsiteController::class, 'search'])->name('website.search');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/vote/{website}', [VoteController::class, 'store'])->name('website.vote');
    Route::delete('/unvote/{website}', [VoteController::class, 'delete'])->name('website.unvote');


    //Admin Website Delete
    Route::delete('/admin/website/{website}', [AdminDeleteWebsiteController::class, 'delete'])->name('admin.website.delete');
    Route::delete('/admin/websites', [AdminDeleteWebsiteController::class, 'deleteMany'])->name('admin.website.delete.many');
});




// ->name('')