<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Models\AdditionalEducation;
use App\Models\PersonalData;
use App\Models\Role;
use App\Models\UserQualification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\School;
use App\Models\Appraisal;
use App\Models\FirstParent;
use App\Models\Parents;
use App\Models\Passport;
use App\Models\SecondParent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Psy\Util\Json;

use function GuzzleHttp\Promise\all;

class EmployeeController extends Controller
{
    protected $users;


    public function __construct()
    {
        $this->users;
    }

    /**
     * @return JsonResponse
     */
    public function getAllCart(): JsonResponse
    {
        return response()->json([
            'code' => 200,
            'message' => "Абитуриенты найдены",
            'content' => CartResource::collection(User::where('stuff', false)->get()),
            'notConfirmed' => User::where('data_confirmed', false)->where('stuff', false)->count()
        ], 200);
    }

    /**
     * @return JsonResponse
     */
    public function getNotConfirmedCart(): JsonResponse
    {
        return response()->json([
            'code' => 200,
            'message' => 'Студенты с не подтверждеными данными найдены',
            'content' => CartResource::collection(
                User::where('data_confirmed', false)->where('stuff', false)->get()
            )
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function cart(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string|digits:11',
            'email' => 'required|string',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required',
            'series' => 'required',
            'number' => 'required',
            'date_of_issue' => 'required|date',
            'issued_by' => 'required',
            'date_of_birth' => 'required|date',
            'gender' => 'required',
            'place_of_birth' => 'required',
            'registration_address' => 'required',
            'lack_of_citizenship' => 'required',
            'school_name' => 'required',
            'number_of_classes' => 'required',
            'year_of_ending' => 'required',
            'number_of_certificate' => 'required',
            'number_of_photo' => 'string',
            'version_of_the_certificate' => 'string',
            'parents.*.name' => 'string|max:255',
            'parents.*.phone' => 'string|max:255',
            'education.form_of_education' => 'string|max:255',
            'education.name_of_educational_institution' => 'string|max:255',
            'education.number_of_diploma' => 'string|max:255',
            'education.year_of_ending' => 'string|max:255',
            'education.qualification' => 'string|max:255',
            'education.specialty' => 'string|max:255',
            'appraisal.*.subject' => 'string',
            'appraisal.*.appraisal' => 'integer|digits:1|between:2,5'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors(),
                'message' => 'Ошибка валидации'
            ], 422);
        }

        $user = User::create([
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make(Str::random(10)),
            'stuff' => false
        ]);

        $user->roles()->attach(Role::where('slug', 'student')->first());
        $user->save();
        $this->users = $user->id;

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
            'user_id' => $this->users
        ]);

        PersonalData::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'user_id' => $this->users
        ]);

        foreach ($request->appraisal as $item) {
            $item['user_id'] = $this->users;
            Appraisal::create($item);
        }
        $appraisal = Appraisal::where('user_id', $this->users)->get();

        $summark = 0;
        foreach ($appraisal as $mark) {
            $summark += $mark->appraisal;
        }

        $middlemark = $summark / count($appraisal);


        School::create([
            'school_name' => $request->school_name,
            'number_of_classes' => $request->number_of_classes,
            'year_of_ending' => $request->year_of_ending,
            'number_of_certificate' => $request->number_of_certificate,
            'number_of_photo' => $request->number_of_photo,
            'version_of_the_certificate' => $request->version_of_the_certificate,
            'middlemark' => round($middlemark, 2),
            'user_id' => $this->users
        ]);

        $fml = explode(' ', $request->parents[0]['name']);
        $parent = [
            'first_name' => $fml[0],
            'middle_name' => $fml[1],
            'last_name' => $fml[2],
            'phoneNumber' => $request->parents[0]['phone']
        ];

        $firstParent = FirstParent::create($parent);

        if ($request[1]) {
            $fml = explode(' ', $request[1]['name']);
            $parent = [
                'first_name' => $fml[0],
                'middle_name' => $fml[1],
                'last_name' => $fml[2],
                'phoneNumber' => $request->parents[1]['phone']
            ];

            $secondParent = SecondParent::create($parent);

            Parents::create([
                'user_id' => $this->users,
                'first_parent_id' => $firstParent->id,
                'second_parent_id' => $secondParent->id
            ]);
        } else {
            Parents::create([
                'user_id' => $this->users,
                'first_parent_id' => $firstParent->id,
            ]);
        }


        AdditionalEducation::create([
            'form_of_education' => $request->education['form_of_education'],
            'name_of_educational_institution' => $request->education['name_of_educational_institution'],
            'number_of_diploma' => $request->education['number_of_diploma'],
            'year_of_ending' => $request->education['year_of_ending'],
            'qualification' => $request->education['qualification'],
            'specialty' => $request->education['specialty'],
            'user_id' => $this->users
        ]);


        return response()->json([
            'code' => 201,
            'message' => "Абитуриент добавлен"
        ], 201);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'code' => 400,
                'message' => 'Пользователь не найден'
            ], 400);
        }
        $user->delete();

        return response()->json([
            'code' => 200,
            'message' => 'Пользователь успешно удален'
        ], 200);
    }

    public function cancelUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'code' => 400,
                'message' => 'Пользователь не найден'
            ], 400);
        }
        $user->reject = true;
        $user->save();

        // Производим пересчет среднего балла для специальности
        $userQualification = UserQualification::where('user_id', $user->id)->get();
        if (!empty($userQualification)) {
            foreach ($userQualification as $userQualificationObject) {
                $qualification = $userQualificationObject->getQualification;
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
        }

        return response()->json([
            'code' => 200,
            'message' => 'Возврат документов пользователем успешно совершен'
        ], 200);
    }

    public function dataConfirmed($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'code' => 400,
                'message' => 'Пользователь не найден'
            ], 400);
        }
        if ($user->data_confirmed == null || $user->data_confirmed == false) {
            $user->data_confirmed = true;
            $user->save();

            return response()->json([
                'code' => 200,
                'message' => "Данные этого пользователя подтверждены"
            ], 200);
        } else {
            $user->data_confirmed = false;
            $user->save();

            return response()->json([
                'code' => 200,
                'message' => "Подтверждение данных для этого пользователя снято"
            ], 200);
        }
    }
}
