<?php

namespace App\Http\Controllers;

use App\Models\AdditionalEducation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdditionalEducationController extends Controller
{
    public function search(Request $request, $id):JsonResponse
    {
        return response()->json([
            'code' => 400,
            $additionalEducation = AdditionalEducation::where("user_id", $request->$id)->get()
        ], 201);
    }
    public function add(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'form_of_education' => 'required|string|max:255',
            'name_of_educational_institution' => 'required|string|max:255',
            'number_of_diploma' => 'required|string|max:255',
            'year_of_ending' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
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
        $additionalEducation = AdditionalEducation::create([
            'form_of_education' => $request->form_of_education,
            'name_of_educational_institution' => $request->name_of_educational_institution,
            'number_of_diploma' => $request->number_of_diploma,
            'year_of_ending' => $request->year_of_ending,
            'qualification' => $request->qualification,
            'specialty' => $request->specialty,
        ])->save();
        return response()->json([
            'additionalEducation' => $additionalEducation,
            'code' => 201,
        ], 201);
    }
}
