<?php

use App\Http\Controllers\API\CastController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MovieController;
use App\Http\Controllers\API\GenreController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\CastMovieController;


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

//Route::post("/v1/movie",[MovieController::class,'store']);

Route::prefix('v1')->group(function(){
    // Route::post("/movie", [MovieController::class,'store']);
    Route::apiResource('cast', CastController::class );
    Route::apiResource('genre', GenreController::class );
    Route::apiResource('movie', MovieController::class );
    Route::apiResource('cast-movie', CastMovieController::class );
    Route::get('dashboard', [MovieController::class, 'dashboard']);
    Route::prefix('auth')->group(function(){
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware("auth:api");
        Route::post('/update-user', [AuthController::class, 'updateUser'])->middleware("auth:api", 'isVerificationAccount');
        Route::post('/generate-otp-code', [AuthController::class, 'generateOtpCode'])->middleware("auth:api");
        Route::post('/verifikasi-akun', [AuthController::class, 'verifikasi'])->middleware("auth:api");
    });

    Route::get('/me',[AuthController::class, 'getUser'])->middleware('auth:api');
    Route::post('profile',[ProfileController::class, 'store'])->middleware('auth:api', 'isVerificationAccount');
    Route::get('/get-profile',[ProfileController::class, 'index'])->middleware('auth:api', 'isVerificationAccount');
    Route::post('/review',[ReviewController::class, 'store'])->middleware('auth:api', 'isVerificationAccount');

});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });