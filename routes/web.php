<?php

use App\Http\Controllers\ThreadController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\SocialAuthController;
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

Route::get('/', function () {
    return view('threads.index');
});

Route::get('/threads/{id}', function ($id) {
    $result = \App\Models\Thread::findOrFail($id);
    return view('threads.view', compact('result'));
});

Route::get('/locale/{locale}', function($locale){
    session(['locale' => $locale]);
    return back();
});

Route::get('/threads', [ThreadController::class, 'index']);
Route::get('/replies/{id}', [ReplyController::class, 'show']);

Route::get('/login/{provider}', [SocialAuthController::class, 'redirect']);
Route::get('/login/{provider}/callback', [SocialAuthController::class, 'callback']);

Route::middleware(['auth'])
    ->group(function(){        
        Route::post('/threads', [ThreadController::class, 'store']);
        Route::put('/threads/{thread}', [ThreadController::class, 'update']);
        Route::get('/threads/{thread}/edit', function (\App\Models\Thread $thread){
            return view('threads.edit', compact('thread'));
        });
        
        Route::post('/replies', [ReplyController::class, 'store']);
    });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
