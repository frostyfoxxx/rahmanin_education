<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompetitionResource;
use App\Http\Resources\QualificationClassifierResource;
use App\Models\Qualification;
use App\Models\QualificationClassifier;
use App\Models\RecordingDate;
use App\Models\RecordingTime;
use App\Models\SpecialtyClassifier;
use App\Models\UserQualification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SecretaryController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getCode(): JsonResponse
    {
        return response()->json([
            'data' => [
                'code' => 200,
                'content' => SpecialtyClassifier::all('code')
            ]
        ], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getQualification(Request $request)
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function postQualificationQuota(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "code" => ['required', 'string', 'exists:specialty_classifiers,code'],
            "specialty" => ['required', 'string', 'exists:specialty_classifiers,specialty'],
            "qualification" => ['required', "string", "exists:qualification_classifiers,qualification"],
            "ft_budget_quota" => ['required', 'numeric'],
            "rm_budget_quota" => ['required', 'numeric'],
            "working_profession" => ['required', 'boolean'],
            "ft_commercial" => ['required', 'boolean'],
            "rm_commercial" => ['required', 'boolean']
        ]);

        if ($validator->fails()) {
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
            "rm_commercial" => $request->rm_commercial,
            "ft_commercial" => $request->ft_commercial
        ]);

        return response()->json([
            'data' => [
                'code' => 201,
                'message' => "Квота создана"
            ]
        ], 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
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

        if (!empty(RecordingDate::where('date_recording', $request->date_recording)->first())) {
            return response()->json([
                'error' => [
                    'code' => 403,
                    'message' => 'Временные окна на эту дату уже созданы'
                ]
            ], 403);
        }


        $intervalBeforeLunch = (strtotime($request->start_lunch) - strtotime($request->time_start)) / ($request->interval * 60);

        $intervalAfterLunch = (strtotime($request->time_ends) - strtotime($request->ends_lunch)) / ($request->interval * 60);

        $interval = [];

        for ($i = 1; $i <= $intervalBeforeLunch; $i++) {
            $interval[] = date("H:i:s", strtotime($request->time_start) + $request->interval * 60 * $i);

        }

        for ($i = 1; $i <= $intervalAfterLunch; $i++) {
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

        return response()->json([
            'data' => [
                'code' => 201,
                'message' => "Временные окна успешно созданы"
            ]
        ], 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteWindow(Request $request)
    {
        RecordingTime::whereHas('getDate', function ($query) use ($request) {
            $query->where('date_recording', $request->date);
        })->delete();
        RecordingDate::where('date_recording', $request->date)->delete();

        return response()->json([
            'data' => [
                'code' => 200,
                'message' => 'Временное окно успешно удалено'
            ]
        ], 200);
    }

    public function competition(Request $request)
    {
//
//        $specialty = SpecialtyClassifier::select('id')->where('specialty', $request->specialty)->first();
//        $qualification = QualificationClassifier::select('id')->whereHas('getSpecialty', function ($query) use ($request) {
//            $query->where('specialty', $request->specialty);
//        })->where('qualification', $request->qualification)->first()->id;
//        $qual = Qualification::where('qualification_classifier_id', QualificationClassifier::select('id')->whereHas('getSpecialty', function ($query) use ($request) {
//            $query->where('specialty', $request->specialty);
//        })->where('qualification', $request->qualification)->first()->id)->first();


        $users = UserQualification::where('qualification_id',
            Qualification::where('qualification_classifier_id',
                QualificationClassifier::select('id')->whereHas('getSpecialty', function ($query) use ($request) {
                    $query->where('specialty', $request->specialty);
                })->where('qualification', $request->qualification)->first()->id)->first()->id)
            ->where('type_education', $request->type_education)
            ->where('form_education', $request->form_education)
            ->orderByDesc('middlemark')
            ->get();

        return response()->json([
            'data' => [
                'code' => 200,
                'message' => 'Пользователи для конкурсной ведомости найдены',
                'content' => CompetitionResource::collection($users)
            ]
        ], 200);

    }
    // TODO: Узнать у Рахманина про контрольные цифры и доделать
    public function statement(Request $request)
    {
        $statement = UserQualification::where('form_education', $request->form_education)->orderBy('qualification_id')->get();

        $array = [];

        for ($i = $statement[0]->qualification_id; $i <= $statement[count($statement) - 1]->qualification_id; $i++) {

            $qualification = QualificationClassifier::whereHas('qualification', function ($query) use ($i) {
                $query->where('id', $i);
            })->first()->qualification;

            $count = 0;
            for ($j = 0; $j < count($statement); $j++) {

                if ($statement[$j]->qualification_id == $i) {
                    $count++;
                }
            }
            $array["$qualification"]['кол-во подданых заявлений'] = $count;
        }

        return $array;

    }


}
