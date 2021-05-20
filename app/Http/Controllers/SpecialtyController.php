<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function addspecialty(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255',
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

        $specialty = Specialty::create([
            'code' => $code,
            'specialty' => $request->specialty,
        ])->save();
        return response()->json([
            'code' => 200,
            'specialty' => $specialty,
        ], 200);
    }
}
