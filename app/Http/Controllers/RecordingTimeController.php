<?php

namespace App\Http\Controllers;

use App\Http\Resources\TimeWindowSecretaryResource;
use App\Http\Resources\TimeWindowStudentResource;
use App\Models\RecordingTime;
use Illuminate\Http\Request;

class RecordingTimeController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRecordingTime(Request $request)
    {
        $user_role = auth('sanctum')->user()->roles[0]->slug;

        $time = RecordingTime::whereHas('getDate', function ($query) use ($request) {
            $query->where('date_recording', $request->date);
        })->get();


        if (count($time) != 0) {
            switch ($user_role) {
                case 'student':
                    return response()->json([
                        'code' => 200,
                        'message' => 'Временные окна найдены',
                        'content' => TimeWindowStudentResource::collection($time)
                    ]);
                    break;
                case 'admission-secretary':
                    return response()->json([
                        'code' => 200,
                        'message' => 'Временные окна найдены',
                        'content' => TimeWindowSecretaryResource::collection($time)
                    ]);
            }
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'Временные окна на данную дату не найдены'
            ], 404);
        }
    }
}
