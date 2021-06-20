<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RecordingTimeController;

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
Route::get('/quota', [\App\Http\Controllers\QualificationController::class, 'getQualificationQuota']); // Получение квот
Route::post('/admin-reg', [\App\Http\Controllers\AdminController::class, 'createAdmin']); // Временный метод создания админа
Route::post('/logout', [UsersController::class, 'logout']);

/*
 * Методы абитуриента
 */
Route::group(['middleware' => ['auth:sanctum', 'role:student']], function () {
    Route::post('/user/personal', [StudentController::class, 'postPersonalData']); // Добавление персональных данных
    Route::get('/user/personal', [StudentController::class, 'getPersonalData']); // Вывод персональных данных
    Route::post('/user/passport', [StudentController::class, 'postPassportData']); //  Добавление паспортных данных
    Route::get('/user/passport', [StudentController::class, 'getPassportData']); // Вывод паспортных данных
    Route::post('/user/school', [StudentController::class, 'postSchoolData']); // Добавление данных о школе
    Route::get('/user/school', [StudentController::class, 'getSchoolData']); // Вывод данных о школе
    Route::post('/user/stuff', [StudentController::class, 'postAppraisalData']); // Добавление предметов аттестата
    Route::get('/user/stuff', [StudentController::class, 'getAppraisalData']); // Вывод предметов с оценками
    Route::post('/user/parents', [StudentController::class, 'postParents']); // Добавление родителей
    Route::get('/user/parents', [StudentController::class, 'getParent']); // Вывод родителей
    Route::post('/user/education', [StudentController::class, 'postAdditionalEducation']); // Добавление данных о доп.образовании
    Route::get('/user/education', [StudentController::class, 'getAdditionalEducation']); // Вывод данных о доп.образовании
    Route::post('/user/specialty', [StudentController::class, 'postQuota']); // Выбор специальности
    Route::get('/user/window', [RecordingTimeController::class, 'getRecordingTime']); // Вывод временных окон
    Route::patch('/user/window', [StudentController::class, 'postRecordingTime']);
});

/*
 * Тестовый метод для мидлвейра ролей
*/
Route::group(['middleware' =>['auth:sanctum', ]], function () {
    Route::get('/me', [UsersController::class, 'user']);

});

/*
 * Методы администратора
 */

Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function () {
    Route::post('admin/create', [AdminController::class, 'AdminCreateUser']); // Создание работников администратором
    Route::post('admin/info', [AdminController::class, 'postInfoEducation']); // Создание информации об учебном заведении
    Route::get('admin/info', [AdminController::class, 'getInfoEducation']); // Вывод информации об учебном заведении
});

/*
 * Методы секратаря
 */

Route::group(['middleware' => ['auth:sanctum', 'role:admission-secretary']], function () {
    Route::get('admin/code', [SecretaryController::class, 'getCode']); // Метод получения кодов специальности
    Route::get('admin/qualification', [SecretaryController::class, 'getQualification']); // Метод получения квалификаций по данной специальности
    Route::post('/admin/quota', [SecretaryController::class, 'postQualificationQuota']); // Добавление квот
    Route::post('/admin/timewindow', [SecretaryController::class, 'createRecording']); // Добавление временных окон
    Route::get('/admin/timewindow', [RecordingTimeController::class, 'getRecordingTime']); // Вывод временных окон
    Route::delete('/admin/timewindow', [SecretaryController::class, 'deleteWindow']); // Удаление временных окон
    Route::get('admin/competition', [SecretaryController::class, 'competition']); // Конкурсная ведомость
    Route::get('admin/statement', [SecretaryController::class, 'statement']);
});

/*
 * Методы сотрудника
 */
Route::group(['middleware' => ['auth:sanctum', 'role:admissions-officer']], function () {
    Route::post('admin/cart', [EmployeeController::class, 'cart']);
    Route::get('admin/cart', [EmployeeController::class, 'getCart']);
    Route::patch('admin/cart/{id}/access', [EmployeeController::class, 'dataConfirmed']);
});

/*
 * Готовые, но не интегрированные методы
 */
Route::post('/admin/role', [\App\Http\Controllers\AdminController::class, 'CreateRole']);
