<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\IdeaLikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

Route::get("lang/{lang}", function ($lang) {

    app()->setLocale($lang);

    session()->put("locale", $lang);

    return redirect()->route("dashboard");
})->name("lang");

Route::get('', [DashboardController::class,'index'])->name("dashboard");

// Route::group(["prefix" => "ideas/", "as"=> "ideas."], function () {

//     Route::get("/{idea}", [IdeaController::class,"show"])->name("show");

//     Route::group(["middleware"=> ["auth"]], function () {

//           Route::post('', [IdeaController::class,'store'])->name("store");

//         Route::get("/{idea}/edit", [IdeaController::class,"edit"])->name("edit");

//         Route::put("/{idea}", [IdeaController::class,"update"])->name("update");


//         Route::delete("/{idea}", [IdeaController::class,"destroy"])->name("destroy");

//         Route::post("/{idea}/comments", [CommentController::class,"store"])->name("comments.store")->middleware("auth");
//     });

// });

Route::resource("ideas", IdeaController::class)->except(["index","create","show"])->middleware("auth");

Route::resource("ideas", IdeaController::class)->only(["show"]);

Route::resource("ideas.comments", CommentController::class)->only(["store"])->middleware("auth");

Route::resource('users', UserController::class)->only(['show']);
Route::resource('users', UserController::class)->only(['edit','update'])->middleware('auth');

Route::get("profile", [UserController::class,"profile"])->middleware("auth")->name("profile");

Route::post("users/{user}/follower", [FollowerController::class,"follow"])->middleware("auth")->name("users.follow");
Route::post("users/{user}/unfollower", [FollowerController::class,"unfollow"])->middleware("auth")->name("users.unfollow");


Route::post("ideas/{idea}/like", [IdeaLikeController::class,"like"])->middleware("auth")->name("ideas.like");
Route::post("ideas/{idea}/unlike", [IdeaLikeController::class,"unlike"])->middleware("auth")->name("ideas.unlike");

Route::get("/feed",FeedController::class)->middleware("auth")->name("feed");


Route::get('/terms', function(){
    return view('terms');
})->name("terms");

Route::get('/admin', [AdminDashboardController::class,'index'])->name("admin.dashboard")->middleware(["auth","can:admin"]);


Route::post('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
})->name('login.github');

Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();
    $user = User::firstOrCreate([
        'email' => $user->email,
    ], [
        'name' => $user->name,
        'password' => 'password',
    ]);

    Auth::login($user);

    return redirect('/');
});

Route::post('/google/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
})->name('login.google');

Route::get('/google/auth/callback', function () {
    $user = Socialite::driver('google')->user();
    $user = User::firstOrCreate([
        'email' => $user->email,
    ], [
        'name' => $user->name,
        'password' => 'password',
    ]);

    Auth::login($user);

    return redirect('/');
});
