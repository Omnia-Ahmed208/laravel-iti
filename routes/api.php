<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('posts', [PostController::class, 'index'])->middleware(middleware:'auth:sanctum');
Route::get('posts/{post}', [PostController::class, 'show']);
Route::post('posts', [PostController::class, 'store']);

// laravel -> application authentication
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return $user->createToken($request->device_name)->plainTextToken;
});


// Eager Loading_____________________

Route::get('user/{id}', function($id){
    // $user = User::findOrFail($id);
    $user = User::with('posts')->findOrFail($id);
    return new UserResource($user);
});

Route::get('/', function(){
    $posts = Post::with('user')->get();
    return PostResource::collection($posts);
});

Route::get('/{id}', function($id){
    $post = Post::with('user')->findOrFail($id);
    return new PostResource($post);
});
