<?php

use App\Http\Controllers\Api\authController;
use App\Http\Controllers\Api\postsController;
use App\Http\Controllers\Api\TagsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route ::apiResource('user',authController::class);
Route::post('login',[authController::class,'login'])->name('userlogin');
Route::get('login',[authController::class,'login'])->name('login');
Route::post('register',[authController::class,'register']);


// Route::group(['middleware' => 'auth:sanctum'],function(){
//     Route::get('user',[UserController::class,'userDetails']);
//     Route::get('logout',[UserController::class,'logout']);
//     Route::post('post/create',[PostsController::class,'store'])->name('create_post');
//     Route::get('post',[PostsController::class,'index'])->name('all_post is publish');
//     Route::get('post/noPublish',[PostsController::class,'show'])->name('all_post_not_published');
//     Route::put('post/Publish/{post}',[PostsController::class,'update'])->name('publish_post');

//     // route('products.index', ['manufacturer' => 'Samsung']);
// });



Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::resource('tags', TagsController::class);
});
Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::get('posts/all',[postsController::class,'all']);
    Route::get('posts/test',[postsController::class,'test']);
    Route::get('/stat', [postsController::class, 'stat']);
    Route::resource('posts', postsController::class);
    Route::get('posts/restore/{post}',[postsController::class,'restore']);
    Route::get('posts/a/{post}',[postsController::class,'restore']);
    // Route::get('posts/a',[postsController::class,'all2']);
    
    
});