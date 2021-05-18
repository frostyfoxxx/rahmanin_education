<?php

namespace App\Http\Controllers;

use App\Models\Passport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PassportController extends Controller
{
    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function search(Request $request, $id): JsonResponse
    {
        return response()->json([
            'message' => 'Ма держи',
            'code' => 400,
            $passport = Passport::where("user_id", $request->$id)->get()
        ], 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'series' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'date_of_issue' => 'required|string|max:255',
            'issued_by' => 'required|string|max:255',
            'date_of_birth' => 'required|string|max:255',
            'male' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'address_of_birth' => 'required|string|max:255',
            'lack_of_citizenship' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'errors' => $validator->errors(),
                    'message' => 'Ошибка запроса'
                ]
            ], 422);
        }
        $passport = Passport::create([
            'series' => $request->series,
            'number' => $request->number,
            'date_of_issue' => $request->date_of_issue,
            'issued_by' => $request->issued_by,
            'date_of_birth' => $request->date_of_birth,
            'male' => $request->male,
            'place_of_birth' => $request->place_of_birth,
            'address_of_birth' => $request->address_of_birth,
            'lack_of_citizenship' => $request->lack_of_citizenship,
        ])->save();
        return response()->json([
            'code' => 200,
            'school' => $passport,
        ], 200);
    }
}
