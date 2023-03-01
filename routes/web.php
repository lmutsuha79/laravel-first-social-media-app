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
use App\Http\Controllers\ExempleController;
use App\Http\Controllers\FollowersController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

Route::get('/', [UserController::class, "showCorrectHomePage"])->name('login');
Route::get('/admin', function () {
      return "only for admins";
})->middleware('can:visitTheAdminPage');


// User related Routes
Route::post('/register', [UserController::class, "register"])->middleware('guest');
Route::post('/login', [UserController::class, "login"])->middleware('guest');
Route::post('/logOut', [UserController::class, "logOut"])->middleware('auth');
Route::get('/manage-avatar', [UserController::class, "showUploadAvatar"])->middleware('auth');
Route::post('/manage-avatar', [UserController::class, "storeAvatar"])->middleware('auth');



// Posts related Routes
Route::get('/create-post', [PostController::class, "showCreatePost"])->middleware("auth");
Route::post('/create-post', [PostController::class, "addNewPost"])->middleware("auth");
Route::get('/posts/{post}', [PostController::class, "showSinglePost"]);
Route::delete('/posts/{post}', [PostController::class, "deletePost"])->middleware('can:delete,post');
Route::get('/posts/edit/{post}', [PostController::class, "showEditPost"])->middleware('can:update,post');
Route::put('/posts/edit/{post}', [PostController::class, "edditPost"])->middleware('can:update,post');


// Profile related Routes
Route::get('/profile/{user:username}', [UserController::class, "showProfile"]);

// Follow Realtred Routes
Route::post('/follow/{user:username}', [FollowersController::class, "addFollow"])->middleware("auth");
