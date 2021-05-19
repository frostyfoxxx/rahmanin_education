<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/signup', [UsersController::class, 'signUp']);
Route::post('/auth', [UsersController::class, 'signIn']);
Route::group(['middleware' => ['auth:sanctum', 'role:student']], function () {
    Route::post('user/personal', [\App\Http\Controllers\StudentController::class, 'postPersonalData']);
    Route::post('/user/passport', [\App\Http\Controllers\StudentController::class, 'postPassportData']);
    Route::post('/user/school', [\App\Http\Controllers\StudentController::class, 'postSchoolData']);
    Route::post('/user/stuff', [\App\Http\Controllers\StudentController::class, 'postAppraisalData']);
    Route::post('/user/parents', [\App\Http\Controllers\StudentController::class, 'postParents']);
});
