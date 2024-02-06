<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GoogleController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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
    return view('welcome');
});

// Route::get('/test', [PostController::class, 'test']);

Route::get('/posts', [PostController::class, 'index'])->name(name:'posts.index')->middleware(middleware:'auth');

Route::group(['middleware' => 'auth'],function(){
    // made authentication on all Routes inside this group
    Route::get('/posts/create', [PostController::class, 'create'])->name(name:'posts.create');

    Route::post('/posts', [PostController::class, 'store']);

    Route::get('/posts/{post}', [PostController::class, 'show'])->name(name:'posts.show');

    Route::get('/posts/edit/{post}', [PostController::class, 'edit'])->name(name:'posts.edit');

    Route::put('/posts/update/{post}', [PostController::class, 'update'])->name(name:'posts.update');

    Route::get('/posts/delete/{post}', [PostController::class, 'delete'])->name(name:'posts.delete');
});

// date formate
Route::get('date',function(){
    $current = new Carbon();
    // echo $current->isoFormat('LLLL'); //comment
    echo $current->toDateString();
    echo "<br>";
    // echo $current->toDateTimeString();
});

// ________________ Comments __________________

Route::post('/comments/{comment}', [CommentController::class, 'store']);
Route::get('/comments/edit/{comment}', [CommentController::class, 'edit'])->name(name:'comments.edit');
Route::put('/comments/update/{comment}', [CommentController::class, 'update'])->name(name:'comments.update');
Route::get('/comments/delete/{comment}', [CommentController::class, 'delete'])->name(name:'comments.delete');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// laravel socialite
use Laravel\Socialite\Facades\Socialite;

// github
Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
})->name('github-auth');

Route::get('/auth/callback', function ()
{
        $githubUser = Socialite::driver('github')->user();

        $user = User::where('email',$githubUser->getEmail())->first();
        // dd($user);

        if(!$user){ //if user not found -> create
            $userNew = User::create( [
                'name' => $githubUser->getName(),
                'email' => $githubUser->getEmail(),
                'google_id' => $githubUser->getId(),
            ]);

            Auth::login($userNew);

            return redirect('/posts');
        }
        else{
            Auth::login($user);
            return redirect('/posts');
        }
});

// google
Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('google-auth');

Route::get('/auth/google/call-back', function ()
{
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('email',$googleUser->getEmail())->first();

        if(!$user){
            $userNew = User::create( [
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
            ]);

            Auth::login($userNew);

            return redirect('/posts');
        }
        else{
            Auth::login($user);
            return redirect('/posts');
        }
});
