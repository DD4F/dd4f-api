<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateController;

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
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::get('no-permission', [AuthController::class, 'noPermission']);
Route::post('/auth', [AuthController::class, 'login']);
Route::group(['middleware' => 'jwt.api'], function () {
    # Candidates
    Route::post('lead', [CandidateController::class, 'store']);
    Route::get('leads', [CandidateController::class, 'index']);
    Route::get('lead/{id}', [CandidateController::class, 'show']);
});

