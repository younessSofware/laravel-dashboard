<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventUserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProductController;
use App\Models\Article;
use App\Models\Category;
use App\Models\event;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\User;

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
// public routes

Route::post('/login', [AuthController::class, 'login']);

// use Socialite;

Route::post('/socialLogin',  [AuthController::class, 'socialLogin'] );
Route::group(['middleware'=> ['auth:sanctum']], function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::get('/events/users/{id}', [EventUserController::class, 'index']);
    Route::post('/events/users/{id}', [EventUserController::class, 'store']);
    Route::delete('/events/users/{user_id}/{event_id}', [EventUserController::class, 'destroy']);
});


// protected routes
Route::group(['middleware'=> ['auth:sanctum', 'restrictothers']], function () {
    Route::get('/statistics', function(){
        return response([
            'admins'=> User::where('role', 'like', 0)->count(),
            'clients'=> User::where('role', 'like', 1)->count(),
            'categories' => Category::count(),
            'events' => event::count(),
            'articles' => Article::count(),
            'notifications' => Notification::count()
        ]
            ,200);
    });
    Route::get('/admin', [AuthController::class, 'indexAdmin']);
    Route::post('/admins/{id}', [AuthController::class, 'update']);
    Route::post('/admins', [AuthController::class, 'storeAdmin']);
    Route::get('/admins/{id}', [AuthController::class, 'show']);

    Route::resource('/users', AuthController::class)->only('index', 'show', 'store', 'destroy');
    Route::post('/users/{id}', [AuthController::class, 'update']);

    Route::get('/events/users/{id}', [EventUserController::class, 'index']);
    Route::post('/events/users/{id}', [EventUserController::class, 'store']);
    Route::delete('/events/users/{user_id}/{event_id}', [EventUserController::class, 'destroy']);


    Route::put('/users/enable/{id}', [AuthController::class, 'enable']);
    Route::resource('/events', EventController::class)->only('index', 'show', 'store', 'destroy');

    Route::post('/events/{id}', [EventController::class, 'update']);

    Route::resource('/categories', CategoryController::class)->only('index', 'show', 'store', 'destroy');
    Route::post('/categories/{id}', [CategoryController::class, 'update']);

    Route::resource('/notifications', NotificationController::class)->only('index', 'show', 'store', 'destroy');
    Route::post('/notifications/{id}', [NotificationController::class, 'update']);

    Route::get('/categories/sort/{type}', [CategoryController::class, 'categoriesByType']);
    Route::resource('/articles', ArticleController::class)->only('index', 'show', 'store', 'destroy');
    Route::post('/articles/{id}', [ArticleController::class, 'update']);
    Route::get('/events/{query}', [ProductController::class, 'search']);
    Route::get('/logout', [AuthController::class, 'logout']);
});
