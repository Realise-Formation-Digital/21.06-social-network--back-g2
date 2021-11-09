<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\AuthenticationController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

// Register new user
Route::post('/create-account', [AuthenticationController::class, 'createAccount']);
// Login user
Route::post('/signin', [AuthenticationController::class, 'signin']);

// Add sanctum middleware to protect our routes.
Route::middleware('auth:sanctum')->group(function () {

    Route::resource('users', UserController::class);

    Route::resource('posts', PostController::class);

    Route::resource('likes', LikeController::class);

    Route::resource('comments', CommentController::class);
    
    Route::post('/sign-out', [AuthenticationController::class, 'logout']);
});
  
// Add login route because Laravel needs it (Or add Accept: application/json to all requests),
  Route::get('/login', function () {
    return response()->json([
      'status_code' => 400,
      'message' => 'error'
    ]);
  })->name('login');


//Route that calls the update function to modify a user_id
Route::patch('users/{id}', [UserController::class, 'update']);











