<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdditionalEducationResource;
use App\Http\Resources\AppraisalResource;
use App\Http\Resources\ChosenSpecialtyResource;
use App\Http\Resources\ParentResource;
use App\Http\Resources\PassportResource;
use App\Http\Resources\PersonalDataResource;
use App\Http\Resources\QuotaResource;
use App\Http\Resources\SchoolResource;
use App\Http\Resources\TimeWindowSecretaryResource;
use App\Http\Resources\TimeWindowStudentResource;
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
use App\Models\UserQualification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getPersonalData()
    {
        $user = auth('sanctum')->user()->id;

        $user = PersonalData::where('user_id', $user)->get();
        if ($user->isEmpty()) {
            return response()->json([
                'code' => 400,
                'message' => "Данные для этого пользователя не найдены"

            ]);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Полученные данные',
            'content' => PersonalDataResource::collection($user),
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
                'code' => 422,
                'errors' => $validator->errors(),
                'message' => 'Ошибка валидации'
            ], 422);
        }

        $user = auth('sanctum')->user()->id;

        /**
         * Проверка на существование записи в БД с таким пользователем
         */
        if (PersonalData::query()->where('user_id', '=', $user)->first()) {
            return response()->json([
                'code' => 400,
                'message' => 'Персональные данные для этого пользователя уже созданы'
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
            'code' => 201,
            'message' => "Персональные данные добавлены"
        ], 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function patchPersonalData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits:11'
        ]);
        if ($validator->fails()) {
            return response()->json([

                'code' => 422,
                'errors' => $validator->errors(),
                'message' => 'Ошибка валидации'

            ], 422);
        }

        $user = auth('sanctum')->user()->id;

        $PersonalData = PersonalData::where('user_id', $user)->first();

        $PersonalData->first_name = $request->input('first_name');
        $PersonalData->middle_name = $request->input('middle_name');
        $PersonalData->last_name = $request->input('last_name');
        $PersonalData->phone = $request->input('phone');
        $PersonalData->save();

        return response()->json([

            'code' => 201,
            'message' => 'Персональные данные обновлены'

        ], 200);
    }

    /**
     * @return JsonResponse
     */
    public function getPassportData()
    {
        $user = auth('sanctum')->user()->id;

        $user = Passport::where('user_id', $user)->get();
        if ($user->isEmpty()) {
            return response()->json([

                'code' => 400,
                'message' => "Данные для этого пользователя не найдены"

            ]);
        }

        return response()->json([

            'code' => 200,
            'message' => 'Полученные данные',
            'content' => PassportResource::collection($user),

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
            'gender' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'registration_address' => 'required|string|max:255',
            'lack_of_citizenship' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([

                'code' => 422,
                'errors' => $validator->errors(),
                'message' => 'Ошибка валидации'

            ], 422);
        }

        $user = auth('sanctum')->user()->id;

        /**
         * Проверка на существование записи в БД с таким пользователем
         */
        if (Passport::query()->where('user_id', '=', $user)->first()) {
            return response()->json([

                'code' => 400,
                'message' => 'Паспортные данные для этого пользователя уже созданы'

            ], 400);
        }

        Passport::create([
            'series' => $request->series,
            'number' => $request->number,
            'date_of_issue' => $request->date_of_issue,
            'issued_by' => $request->issued_by,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'place_of_birth' => $request->place_of_birth,
            'registration_address' => $request->registration_address,
            'lack_of_citizenship' => $request->lack_of_citizenship,
            'user_id' => $user
        ]);

        return response()->json([

            'code' => 201,
            'message' => "Информация о паспортных данных добавлена"

        ], 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function patchPassportData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'series' => 'required|string|max:4',
            'number' => 'required|string|max:6',
            'date_of_issue' => 'required|date_format:Y-m-d',
            'issued_by' => 'required|string|max:255',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'gender' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'registration_address' => 'required|string|max:255',
            'lack_of_citizenship' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([

                'code' => 422,
                'errors' => $validator->errors(),
                'message' => 'Ошибка валидации'

            ], 422);
        }

        $user = auth('sanctum')->user()->id;

        $passportData = Passport::where('user_id', $user)->first();

        $passportData->series = $request->input('series');
        $passportData->number = $request->input('number');
        $passportData->date_of_issue = $request->input('date_of_issue');
        $passportData->issued_by = $request->input('issued_by');
        $passportData->date_of_birth = $request->input('date_of_birth');
        $passportData->gender = $request->input('gender');
        $passportData->place_of_birth = $request->input('place_of_birth');
        $passportData->registration_address = $request->input('registration_address');
        $passportData->lack_of_citizenship = $request->input('lack_of_citizenship');

        $passportData->save();

        return response()->json([

            'code' => 201,
            'message' => 'Паспортные данные изменены'

        ], 201);
    }


    /**
     * @return JsonResponse
     */
    public function getSchoolData(): JsonResponse
    {
        $user = auth('sanctum')->user()->id;
        return response()->json([

            'code' => 200,
            'message' => 'Полученные данные',
            'content' => SchoolResource::collection(School::where('user_id', $user)->get())

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

                'code' => 422,
                'errors' => $validator->errors(),
                'message' => 'Ошибка валидации'

            ], 422);
        }

        $user = auth('sanctum')->user()->id;

        /**
         * Проверка на существование записи в БД с таким пользователем
         */
        if (School::query()->where('user_id', '=', $user)->first()) {
            return response()->json([

                'code' => 400,
                'message' => 'Данные о школе для этого пользователя уже созданы'

            ], 400);
        }


        School::create([
            'school_name' => $request->school_name,
            'number_of_classes' => $request->number_of_classes,
            'year_of_ending' => $request->year_of_ending,
            'number_of_certificate' => $request->number_of_certificate,
            'user_id' => $user
        ]);

        return response()->json([

            'code' => 201,
            'message' => 'Данные о школе добавлены'

        ], 201);
    }

    public function patchSchoolData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'school_name' => 'required|string|max:255',
            'number_of_classes' => 'required|integer',
            'year_of_ending' => 'required|date_format:Y',
            'number_of_certificate' => 'required|numeric|digits:14',
        ]);

        if ($validator->fails()) {
            return response()->json([

                'code' => 422,
                'errors' => $validator->errors(),
                'message' => 'Ошибка валидации'

            ], 422);
        }

        $user = auth('sanctum')->user()->id;

        $schoolData = School::where('user_id', $user)->first();
        $schoolData->school_name = $request->input('school_name');
        $schoolData->number_of_classes = $request->input('number_of_classes');
        $schoolData->year_of_ending = $request->input('year_of_ending');
        $schoolData->number_of_certificate = $request->input('number_of_certificate');

        $schoolData->save();

        return response()->json([

            'code' => 201,
            'message' => 'Данные о школе обновлены'

        ], 201);
    }

    /**
     * @return JsonResponse
     */
    public function getAppraisalData(): JsonResponse
    {
        $user = auth('sanctum')->user()->id;
        return response()->json([

            'code' => 200,
            'message' => 'Полученные данные',
            'content' => AppraisalResource::collection(Appraisal::where('user_id', $user)->get())

        ], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function postAppraisalData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*.subject' => 'required|string|max:255',
            '*.appraisal' => 'required|integer|digits:1|between:2,5'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors(),
                'message' => 'Ошибка валидации'
            ], 422);
        }

        $user = auth('sanctum')->user()->id;

        $appraisal = Appraisal::select('subject')->where('user_id', $user)->get();
        $chosenSubject = [];
        for ($i = 0; $i < count($appraisal); $i++) {
            $chosenSubject[$i] = $appraisal[$i]->subject;
        }

        foreach ($request->all() as $item) {
            if (in_array($item['subject'], $chosenSubject)) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Такой предмет уже добавлен'
                ], 400);
            }

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
            'code' => 201,
            'message' => 'Предметы с оценками добавлены'
        ], 201);
    }

    /**
     * @return JsonResponse
     */
    public function getParent(): JsonResponse
    {
        $user = auth('sanctum')->user()->id;
        $parent = Parents::where('user_id', $user)->first();

        if (empty($parent)) {
            return response()->json([
                'code' => 404,
                'message' => "Родители не добавлены. Пожалуйста, добавьте родителей"
            ], 404);
        }


        $firstParent = FirstParent::find($parent->first_parent_id);

        if ($secondParent = SecondParent::find($parent->second_parent_id)) {
            return response()->json([

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
                        'phone_number' => $secondParent->phoneNumber,
                    ]
                ]

            ], 200);
        }

        return response()->json([

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
                'code' => 422,
                'errors' => $validator->errors(),
                'message' => 'Ошибка запроса'
            ], 422);
        }

        $user = auth('sanctum')->user()->id;

        /**
         * Проверка на существование записи в БД с таким пользователем
         */
        if (count(Parents::query()->where('user_id', '=', $user)->get()) > 1) {
            return response()->json([
                'code' => 400,
                'message' => 'Родители для этого пользователя уже созданы'
            ], 400);
        }

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
            'code' => 201,
            'message' => 'Данные о родителях добавлены'
        ], 201);
    }

    /**
     * @return JsonResponse
     */
    public function getAdditionalEducation(): JsonResponse
    {
        $user = auth('sanctum')->user()->id;
        return response()->json([
            'content' => AdditionalEducationResource::collection(AdditionalEducation::where('user_id', $user)->get()),
            'code' => 200,
            'message' => 'Получены данные',
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
                'code' => 422,
                'errors' => $validator->errors(),
                'message' => 'Ошибка валидации'
            ], 422);
        }

        $user = auth('sanctum')->user()->id;

        /**
         * Проверка на существование записи в БД с таким пользователем
         */
        if (AdditionalEducation::query()->where('user_id', '=', $user)->first()) {
            return response()->json([
                'code' => 400,
                'message' => 'Данные о дополнительном образовании для этого пользователя уже созданы'
            ], 400);
        }

        AdditionalEducation::create([
            'form_of_education' => $request->form_of_education,
            'name_of_educational_institution' => $request->name_of_educational_institution,
            'number_of_diploma' => $request->number_of_diploma,
            'year_of_ending' => $request->year_of_ending,
            'qualification' => $request->qualification,
            'specialty' => $request->specialty,
            'user_id' => $user
        ])->save();

        return response()->json([

            'code' => 201,
            "message" => "Данные о доп.образовании добавлены"

        ], 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function patchAdditionalEducation(Request $request)
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

                'code' => 422,
                'errors' => $validator->errors(),
                'message' => 'Ошибка валидации'

            ], 422);
        }

        $user = auth('sanctum')->user()->id;

        $education = AdditionalEducation::where('user_id', $user)->first();

        $education->form_of_education = $request->input('form_of_education');
        $education->name_of_educational_institution = $request->input('name_of_educational_institution');
        $education->number_of_diploma = $request->input('number_of_diploma');
        $education->year_of_ending = $request->input('year_of_ending');
        $education->qualification = $request->input('qualification');
        $education->specialty = $request->input('specialty');

        $education->save();

        return response()->json([

            'code' => 201,
            'message' => 'Данные о дополнительном образовании обновлены'

        ], 201);
    }

    // TODO: Сделать проверку вводимых данных (форма обучения[Очная и зочная] и тип обучения[Бюджет и коммерция])
    public function postQuota(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*.code' => ['required', 'string', 'exists:specialty_classifiers,code'],
            '*.specialty' => ['required', 'string', 'exists:specialty_classifiers,specialty'],
            '*.qualification' => ['required', 'string', 'exists:qualification_classifiers,qualification'],
            '*.form_education' => ['required', 'string']
        ]);


        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => 'Ошибка валидации',
                'errors' => $validator->errors()
            ]);
        }

        if (count($request->all()) > 2) {
            return response()->json([
                'code' => 400,
                'message' => 'Выбрано более двух специальностей'
            ]);
        }


        $user = auth('sanctum')->user()->id;

        $count = UserQualification::where('user_id', $user)->count();

        if ($count >= 2) {
            return response()->json([
                'code' => 400,
                'message' => "Вы уже выбрали специальности"

            ], 400);
        }

        if ($count + count($request->all()) > 2) {
            return response()->json([
                'code' => 400,
                'message' => "Вы можете добавить только одну специальность"
            ], 400);
        }


        foreach ($request->all() as $item) {
            $qualification = Qualification::whereHas('getQualificationClassifier', function ($query) use ($item) {
                $query->where('qualification', $item['qualification']);
            })->first();

            if ($quota = UserQualification::where('user_id', $user)->first()) {
                if ($quota->qualification_id == $qualification->id) {
                    return response()->json([
                        "code" => 400,
                        "message" => "Вы уже выбрали данную специальность"
                    ], 400);
                }
            }

            UserQualification::create([
                'qualification_id' => $qualification->id,
                'user_id' => $user,
                'middlemark' => School::where('user_id', $user)->first()->middlemark,
                'form_education' => $item['form_education'],
                'type_education' => $item['type_education']
            ]);
            $lastMiddlemark = UserQualification::select('middlemark')->where(
                'qualification_id',
                '=',
                $qualification->id
            )->whereHas('users', function ($query) {
                $query->where('reject', '!=', true);
            })->orderBy('middlemark')->limit($qualification->ft_budget_quota)->first()->middlemark;

            $qualification->average_score_invite = $lastMiddlemark;
            $qualification->save();
        }


        return response()->json([
            'code' => 201,
            'message' => 'Специальности добавлены',
        ], 201);
    }


    public function postRecordingTime(Request $request)
    {
        $time = RecordingTime::find($request->id);
        if ($time->user_id != null) {
            return response()->json([
                'code' => 403,
                'message' => "Данное временное окно уже занято"
            ], 403);
        }

        $user = RecordingTime::where('user_id', auth('sanctum')->user()->id)->first();

        if (!empty($user)) {
            return response()->json([
                'code' => 403,
                'message' => 'Вы не можете бронировать более одной записи'            ], 403);
        }

        $time->user_id = auth('sanctum')->user()->id;
        $time->save();

        return response()->json([

            'code' => 201,
            'message' => "Временное окно успешно занято"

        ], 201);
    }

    public function getChosenSpecialty()
    {
        $user = auth('sanctum')->user()->id;

        $user = UserQualification::where('user_id', $user)->get();
        if ($user->isEmpty()) {
            return response()->json([
                'code' => 400,
                'message' => "Данные для этого пользователя не найдены"
            ]);
        }

        return response()->json([

            'code' => 200,
            'message' => 'Выбранные специальности получены',
            'content' => ChosenSpecialtyResource::collection($user)

        ], 200);
    }
}
