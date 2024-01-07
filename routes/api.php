<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\AlbumController; 
use App\Http\Controllers\PictureController; 
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\CurrentController;
use App\Http\Controllers\AlbumPictureController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/albums', [AlbumController::class, 'index']);
Route::get('/albums/{id}', [AlbumController::class, 'show']);
Route::get('/album/{slug}', [AlbumController::class, 'bySlug']);
Route::get('/pictures', [PictureController::class, 'index']);
Route::get('/pictures/{id}', [PictureController::class, 'show']);
Route::get('/cvs', [CvController::class, 'index']);
Route::get('/cvs/{id}', [CvController::class, 'show']);
Route::get('/album-pictures', [AlbumPictureController::class, 'index']);
Route::get('/album-pictures/{id}', [AlbumPictureController::class, 'show']);

Route::get('/currents', [CurrentController::class, 'index']);
Route::get('/articles', [ArticleController::class, 'index']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'createUser']);

Route::get('/is-auth', function () {
    if (Auth::check()) {
        $response = [
            'success' => true,
            'message' => 'user is authenticated',
        ];

        return response()->json($response, 200);
    }
    else {
            $response = [
            'success' => false,
            'message' => 'user is unauthenticated',
        ];

        return response()->json($response, 401);
    }
});

/************************** auth *******************************/
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout',  [AuthController::class, 'logout']);
    
    Route::post('/albums', [AlbumController::class, 'store']);
    Route::delete('/albums/{album}', [AlbumController::class, 'destroy']);
    Route::put('/albums/{album}', [AlbumController::class, 'update']);

    Route::post('/album-pictures', [AlbumPictureController::class, 'store']);
    Route::delete('/album-pictures/{id}', [AlbumPictureController::class, 'destroy']);
    
    Route::post('/upload', [PictureController::class, 'store']);
    Route::put('/pictures/{picture}', [PictureController::class, 'update']);
    Route::delete('/pictures/{picture}', [PictureController::class, 'destroy']);
    
    Route::post('/cvs', [CvController::class, 'store']);
    Route::put('/cvs/{cv}', [CvController::class, 'update']);
    Route::delete('/cvs/{cv}', [CvController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
