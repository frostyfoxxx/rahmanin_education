<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\School;
use App\Models\Appraisal;
use App\Models\FirstParent;
use App\Models\Parents;
use App\Models\Passport;
use App\Models\SecondParent;
use Illuminate\Validation\Validator;

class EmployeeController extends Controller
{
    public function AddUsers(Request $request): JsonResponse {
        //Сотрудник: Картотека. Добавление абитуриента
        $validator = Validator::make($request->all(), [


        ]);
    }
    public function DeleteUsers() {
        //Сотрудник: Картотека. Удаление пользователя
    }
    public function ReturnDocu() {
        //Сотрудник: Картотека. Возврат документов
    }
    public function DataConfirmed() {
        //Сотрудник: Картотека. Данные подтверждены.
    }
}
