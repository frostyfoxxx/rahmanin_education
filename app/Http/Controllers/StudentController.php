<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdditionalEducationResource;
use App\Http\Resources\AppraisalResource;
use App\Http\Resources\ParentResource;
use App\Http\Resources\PassportResource;
use App\Http\Resources\PersonalDataResource;
use App\Http\Resources\QuotaResource;
use App\Http\Resources\SchoolResource;
use App\Models\AdditionalEducation;
use App\Models\Appraisal;
use App\Models\FirstParent;
use App\Models\Parents;
use App\Models\Passport;
use App\Models\PersonalData;
use App\Models\Qualification;
use App\Models\RecordingTime;
use App\Models\School;
use App\Models\SecondParent;
use App\Models\User;
use App\Models\UserQualification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Builder;


class StudentController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getPersonalData(): JsonResponse
    {
        $user = auth('sanctum')->user()->id;
        return response()->json([
            'data' => [
                'code' => 200,
                'message' => 'Полученные данные',
                'content' => PersonalDataResource::collection(PersonalData::where('user_id', $user)->get()),
            ]
        ], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postPersonalData(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits:11'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'errors' => $validator->errors(),
                    'message' => 'Ошибка валидации'
                ]
            ], 422);
        }

        $user = auth('sanctum')->user()->id;

        if (PersonalData::query()->where('user_id', '=', $user)->first()) {
            return response()->json([
                'error' => [
                    'code' => 400,
                    'message' => 'Персональные данные для этого пользователя уже созданы'
                ]
            ], 400);
        }

        PersonalData::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'user_id' => $user
        ]);

        return response()->json([
            'data' => [
                'code' => 201,
                'message' => "Information update"
            ],
        ], 201);
    }

    /**
     * @return JsonResponse
     */
    public function getPassportData(): JsonResponse
    {
        $user = auth('sanctum')->user()->id;
        return response()->json([
            'data' => [
                'code' => 200,
                'message' => 'Полученные данные',
                'content' => PassportResource::collection(Passport::where('user_id', $user)->get()),
            ]
        ], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function postPassportData(Request $request): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'series' => 'required|string|max:4',
            'number' => 'required|string|max:6',
            'date_of_issue' => 'required|date_format:Y-m-d',
            'issued_by' => 'required|string|max:255',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'male' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'registration_address' => 'required|string|max:255',
            'lack_of_citizenship' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'errors' => $validator->errors(),
                    'message' => 'Ошибка валидации'
                ]
            ], 422);
        }

        $user = auth('sanctum')->user()->id;


        Passport::create([
            'series' => $request->series,
            'number' => $request->number,
            'date_of_issue' => $request->date_of_issue,
            'issued_by' => $request->issued_by,
            'date_of_birth' => $request->date_of_birth,
            'male' => $request->male,
            'place_of_birth' => $request->place_of_birth,
            'registration_address' => $request->registration_address,
            'lack_of_citizenship' => $request->lack_of_citizenship,
            'user_id' => $user
        ]);

        return response()->json([
            'data' => [
                'code' => 201,
                'message' => "Информация о паспортных данных обновлена"
            ]
        ], 201);


    }

    /**
     * @return JsonResponse
     */
    public function getSchoolData(): JsonResponse
    {
        $user = auth('sanctum')->user()->id;
        return response()->json([
            'data' => [
                'code' => 200,
                'message' => 'Полученные данные',
                'content' => SchoolResource::collection(School::where('user_id', $user)->get())
            ]
        ], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function postSchoolData(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'school_name' => 'required|string|max:255',
            'number_of_classes' => 'required|integer',
            'year_of_ending' => 'required|date_format:Y',
            'number_of_certificate' => 'required|numeric|digits:14',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'errors' => $validator->errors(),
                    'message' => 'Ошибка валидации'
                ]
            ], 422);
        }

        $user = auth('sanctum')->user()->id;


        School::updateOrCreate([
            'school_name' => $request->school_name,
            'number_of_classes' => $request->number_of_classes,
            'year_of_ending' => $request->year_of_ending,
            'number_of_certificate' => $request->number_of_certificate,
            'user_id' => $user
        ]);

        return response()->json([
            'data' => [
                'code' => 201,
                'message' => 'Данные о школе обновлены'
            ]
        ], 201);
    }

    /**
     * @return JsonResponse
     */
    public function getAppraisalData(): JsonResponse
    {
        $user = auth('sanctum')->user()->id;
        return response()->json([
            'data' => [
                'code' => 200,
                'message' => 'Полученные данные',
                'content' => AppraisalResource::collection(Appraisal::where('user_id', $user)->get())
            ]
        ], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function postAppraisalData(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            '*.subject' => 'required|string|max:255',
            '*.appraisal' => 'required|integer|digits:1|between:2,5'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'errors' => $validator->errors(),
                    'message' => 'Ошибка валидации'
                ]
            ], 422);
        }

        $user = auth('sanctum')->user()->id;

        foreach ($request->all() as $item) {
            $item['user_id'] = $user;
            Appraisal::create($item);
        }

        $appraisal = Appraisal::where('user_id', $user)->get();

        $summark = 0;
        foreach ($appraisal as $mark) {
            $summark += $mark->appraisal;
        }

        $middlemark = $summark / count($appraisal);

        $school = School::where('user_id', $user)->first();
        $school['middlemark'] = $middlemark;
        $school->save();


        return response()->json([
            'data' => [
                'code' => 201,
                'message' => 'Предметы с оценками добавлены'
            ]
        ], 201);
    }

    public function getParent() // TODO: Пофиксить вывод родителей
    {

        $user = auth('sanctum')->user()->id;
//        $parents = Parents::whereHas($user, function ($query) {
//            $query->where('first_parent_id');
//        })->whereHas($user, function ($query) {
//            $query->where('second_parent_id');
//        })->get();
        $parent = Parents::where('user_id', $user)->first();

        $firstParent = FirstParent::find($parent->first_parent_id);

        if ($secondParent = SecondParent::find($parent->second_parent_id)) {
            return response()->json([
                'data' => [
                    'code' => 200,
                    'message' => "Родители найдены",
                    'content' => [
                        [
                            'first_name' => $firstParent->first_name,
                            'middle_name' => $firstParent->middle_name,
                            'last_name' => $firstParent->last_name,
                            'phone_number' => $firstParent->phoneNumber,
                        ],
                        [
                            'first_name' => $secondParent->first_name,
                            'middle_name' => $secondParent->middle_name,
                            'last_name' => $secondParent->last_name,
                            'phone_number' => $secondParent->phone_number,
                        ]
                    ]
                ]
            ], 200);
        }

        return response()->json([
            'data' => [
                'code' => 200,
                'message' => "Родители найдены",
                'content' => [
                    [
                        'first_name' => $firstParent->first_name,
                        'middle_name' => $firstParent->middle_name,
                        'last_name' => $firstParent->last_name,
                        'phone_number' => $firstParent->phoneNumber,
                    ]
                ]
            ]

        ], 200);


    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function postParents(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            '*.name' => 'string|max:255',
            '*.phone' => 'string|max:255',
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

        $user = auth('sanctum')->user()->id;
        $fml = explode(' ', $request[0]['name']);
        $parent = [
            'first_name' => $fml[0],
            'middle_name' => $fml[1],
            'last_name' => $fml[2],
            'phoneNumber' => $request[0]['phone']
        ];

        $firstParent = FirstParent::create($parent);

        if ($request[1]) {
            $fml = explode(' ', $request[1]['name']);
            $parent = [
                'first_name' => $fml[0],
                'middle_name' => $fml[1],
                'last_name' => $fml[2],
                'phoneNumber' => $request[1]['phone']
            ];

            $secondParent = SecondParent::create($parent);

            Parents::create([
                'user_id' => $user,
                'first_parent_id' => $firstParent->id,
                'second_parent_id' => $secondParent->id
            ]);
        } else {
            Parents::create([
                'user_id' => $user,
                'first_parent_id' => $firstParent->id,
            ]);
        }

        return response()->json([
            'data' => [
                'code' => 201,
                'message' => 'Данные о родителях добавлены'
            ]
        ], 201);

    }

    /**
     * @return JsonResponse
     */
    public function getAdditionalEducation(): JsonResponse
    {
        $user = auth('sanctum')->user()->id;
        return response()->json([
            'items' => [
                'item' => AdditionalEducationResource::collection(AdditionalEducation::where('user_id', $user)->get()),
                'code' => 200,
                'message' => 'Получены данные',
            ]
        ], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function postAdditionalEducation(Request $request): JsonResponse
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
                    'message' => 'Ошибка валидации'
                ]
            ], 422);
        }
        $id = auth('sanctum')->user()->id;

        $additionalEducation = AdditionalEducation::create([
            'form_of_education' => $request->form_of_education,
            'name_of_educational_institution' => $request->name_of_educational_institution,
            'number_of_diploma' => $request->number_of_diploma,
            'year_of_ending' => $request->year_of_ending,
            'qualification' => $request->qualification,
            'specialty' => $request->specialty,
            'user_id' => $id
        ])->save();

        return response()->json([
            'data' => [
                'code' => 201,
                "message" => "Данные о доп.образовании добавлены"
            ]
        ], 201);

    }

    public function postQuota(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*.code' => ['required', 'string', 'exists:specialty_classifiers,code'],
            '*.specialty' => ['required', 'string', 'exists:specialty_classifiers,specialty'],
            '*.qualification' => ['required', 'string', 'exists:qualification_classifiers,qualification']
        ]);


        if ($validator->fails()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Ошибка валидации',
                    'errors' => $validator->errors()
                ]
            ]);
        }

        $user = auth('sanctum')->user()->id;

        $marks = Appraisal::where('user_id', $user)->get();
        $middlemark = 0;

        foreach ($marks as $mark) {
            $middlemark += $mark->appraisal;
            $mark->appraisal;
        }

        $middlemark = $middlemark / count($marks);

        foreach ($request->all() as $item) {
            $qualification = Qualification::whereHas('getQualificationClassifier', function ($query) use ($item) {
                $query->where('qualification', $item['qualification']);
            })->first();


            UserQualification::create([
                'qualification_id' => $qualification->id,
                'user_id' => $user,
                'middlemark' => $middlemark,
                'form_education' => $item['form_education'],
                'type_education' => $item['type_education']
            ]);
        }

        return response()->json([
            'data' => [
                'code' => 201,
                'message' => 'Специальности добавлены',
            ]
        ], 201);

    }

    public function getRecordingTime(Request $request)
    {
        return $time = RecordingTime::whereHas('getDate', function ($query) use ($request) {
            $query->where('date_recording', $request->date_recording);
        })->get();


    }

}
