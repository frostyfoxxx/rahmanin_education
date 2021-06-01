<?php

namespace App\Http\Controllers;

use App\Http\Resources\QualificationClassifierResource;
use App\Models\Qualification;
use App\Models\QualificationClassifier;
use App\Models\RecordingDate;
use App\Models\RecordingTime;
use App\Models\SpecialtyClassifier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Psr7\str;

class SecretaryController extends Controller
{
    public function getCode()
    {
        return response()->json([
            'data' => [
                'code' => 200,
                'content' => SpecialtyClassifier::all('code')
            ]
        ], 200);
    }

    public function getQualification(Request $request) // TODO: Сделать не через костыль
    {
        $qualification = QualificationClassifier::whereHas('getSpecialty', function (Builder $query) use ($request) {
            $query->where('code', '=', $request->code);
        })->get();

        $specialty = SpecialtyClassifier::where('code', $request->code)->first();
        return response()->json([
            'data' => [
                'code' => 200,
                'content' => [
                    'specialty' => $specialty->specialty,
                    'qualifications' => QualificationClassifierResource::collection($qualification)
                ]
            ]
        ]);
    }

    public function postQualificationQuota(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "code" => ['required', 'string', 'exists:specialty_classifiers,code'],
            "specialty" => ['required', 'string', 'exists:specialty_classifiers,specialty'],
            "qualification"  => ['required', "string", "exists:qualification_classifiers,qualification"],
            "ft_budget_quota" => ['required', 'numeric'],
            "rm_budget_quota" => ['required', 'numeric'],
            "working_profession" => ['required', 'boolean'],
            "budget" => ['required', 'boolean'],
            "commercial" => ['required', 'boolean']
        ]);

        // TODO: Пофиксить миграции квот, добавить поля 'commercial_quota', убрать boolean 'budget' and 'commercial'.



        if($validator->fails()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => "Ошбика валидации",
                    "errors" => $validator->errors()
                ]
            ]);
        }

        $qualification = QualificationClassifier::where('qualification', $request->qualification)->first();

        Qualification::create([
            "qualification_classifier_id" => $qualification->id,
            "ft_budget_quota" => $request->ft_budget_quota,
            "rm_budget_quota" => $request->rm_budget_quota,
            "working_profession" => $request->working_profession,
            "budget" => $request->budget,
            "commercial" => $request->commercial
        ]);

        return response()->json([
            'data' => [
                'code' => 201,
                'message' => "Квота создана"
            ]
        ], 201);
    }

    public function createRecording(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_recording' => ['required', 'date_format:Y-m-d'],
            'time_start' => ['required', 'date_format:H:i:s'],
            'time_ends' => ['required', 'date_format:H:i:s'],
            'interval' => ['required', 'integer'],
            'start_lunch' => ['required', 'date_format:H:i:s'],
            'ends_lunch' => ['required', 'date_format:H:i:s']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => "Ошибка валидации",
                    'errors' => $validator->errors()
                ]
            ]);
        }



        echo $intervalBeforeLunch = (strtotime($request->start_lunch) - strtotime($request->time_start)) / ($request->interval * 60);
        echo "  ";
        echo $intervalAfterLunch = (strtotime($request->time_ends) - strtotime($request->ends_lunch)) / ($request->interval * 60);

        $interval = [];

        for ($i = 1; $i<=$intervalBeforeLunch; $i++) {
            $interval[] = date("H:i:s", strtotime($request->time_start) + $request->interval * 60 * $i);

        }

        for ($i = 1; $i<=$intervalAfterLunch; $i++) {
            $interval[] = date("H:i:s", strtotime($request->ends_lunch) + $request->interval * 60 * $i);
        }

        $date = RecordingDate::create([
            'date_recording' => $request->date_recording
        ]);


        foreach ($interval as $item) {
            RecordingTime::create([
                'daterecording_id' => $date->id,
                'recording_start' => date("H:i:s", strtotime($item) - $request->interval * 60),
                'recording_ends' => $item
            ]);
        }


    }
}
