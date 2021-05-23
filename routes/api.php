<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;

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
 * Методы общедоступные всем
 */
Route::post('/signup', [UsersController::class, 'signUp']); // Регистрация
Route::post('/auth', [UsersController::class, 'signIn']); // Авторизация
Route::post('/admin-reg', [\App\Http\Controllers\AdminController::class, 'createAdmin']); // Временный метод создания админа

/*
 * Методы абитуриента
 */
Route::group(['middleware' => ['auth:sanctum', 'role:student']], function () {
    Route::post('user/personal', [StudentController::class, 'postPersonalData']); // Добавление персональных данных
    Route::post('/user/passport', [StudentController::class, 'postPassportData']); //  Добавление паспортных данных
    Route::post('/user/school', [StudentController::class, 'postSchoolData']); // Добавление данных о школе
    Route::post('/user/stuff', [StudentController::class, 'postAppraisalData']); // Добавление предметов аттестата
    Route::post('/user/parents', [StudentController::class, 'postParents']); // Добавление родителей
    Route::post('/user/education', [StudentController::class, 'postAdditionalEducation']); // Добавление данных о доп.образовании
});

/*
 * Тестовый метод для мидлвейра ролей
*/
Route::group(['middleware' =>['auth:sanctum', 'role:admin', 'role:student']], function () {
    Route::get('/me', [UsersController::class, 'user']);
});

/*
 * Методы администратора
 */

Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function () {
    Route::post('admin/create', [AdminController::class, 'AdminCreateUser']);
});

/*
 * Готовые, но не интегрированные методы
 */

Route::get('/code', [\App\Http\Controllers\QualificationController::class, 'getCode']);
Route::get('/qualification', [\App\Http\Controllers\QualificationController::class, 'getQualification']);
Route::post('/qualification', [\App\Http\Controllers\QualificationController::class, 'postQualificationQuota']);
Route::get('/quota', [\App\Http\Controllers\QualificationController::class, 'getQualificationQuota']);
Route::post('/admin/create', [\App\Http\Controllers\AdminController::class, 'AdminCreateUser']);
Route::post('/admin/role', [\App\Http\Controllers\AdminController::class, 'CreateRole']);
