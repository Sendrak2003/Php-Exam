<?php

namespace App\Http\Controllers\api\V1;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public bool $token = true;
    public function __construct()
    {
        $this->middleware('jwt.auth')->except(['login', 'register']);
    }


    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required|string',
                'password' => 'required|string',
            ], [
                'required' => 'Поле :attribute обязательно для заполнения.',
                'string' => 'Поле :attribute должно быть строкой.',
                'username.required' => 'Поле "Имя пользователя" обязательно для заполнения.',
                'password.required' => 'Поле "Пароль" обязательно для заполнения.',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $credentials = [
                'password' => $request->password
            ];

            $username = $request->username;

            // Проверяем, является ли введенное значение email или логин.
            if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
                $credentials['email'] = $username;
            } else {
                $credentials['login'] = $username;
            }

            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['errors' => [
                    'success' => false,
                    'message' => 'Некорректные данные'],
                ], 401);
            }

            $user = Auth::user();

            return response()->json([
                'status' => 'success',
                'authorization' => [
                    'token' => $token,
                    'role_id' => $user->role_id,
                    'type' => 'bearer',
                ]
            ]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }


    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'inn' => [
                    'required',
                    'string',
                    'unique:users,inn',
                    function ($attribute, $value, $fail) {
                        if (!preg_match('/^\d+$/', $value)) {
                            $fail('Поле номера паспорта должно содержать только цифры.');
                        }

                        if (strlen($value) !== 10 && strlen($value) !== 12) {
                            $fail('Поле номера паспорта должно быть либо 10, либо 12 цифр.');
                        }
                    },
                ],
                'fullName' => ['required', 'string', 'regex:/^([А-ЯЁ][а-яё]+)\s([А-ЯЁ][а-яё]+)(\s([А-ЯЁ][а-яё]+))?$/u'],
                'login' => ['required', 'string', 'unique:users,login', 'max:8', 'regex:/^[a-zA-Z0-9]+$/u'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6', 'max:32', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[_#?!@$%^&*-]).{8,32}$/'],
                'confirmPassword' => ['required', 'string', 'same:password'],
                'address' => ['required', 'string'],
                'phoneNumber' => ['required', 'string', 'unique:users,phoneNumber', 'regex:/^(\+7|8)\s?\(\d{3}\)\s?\d{3}[-]?\d{2}[-]?\d{2}$/'],
                'dateOfBirth' => ['required', 'date', 'before_or_equal:' . \Carbon\Carbon::now()->subYears(18)->format('Ymd')],
            ], [
                'inn.required' => 'Поле номера паспорта обязательно для заполнения.',
                'inn.string' => 'Поле номера паспорта должно быть строкой.',
                'inn.unique' => 'Такой номер паспорта уже зарегистрирован.',
                'inn.regex' => 'Поле номера паспорта должно содержать только цифры.',

                'fullName.required' => 'Поле ФИО обязательно для заполнения.',
                'fullName.string' => 'Поле ФИО должно быть строкой.',
                'fullName.regex' => 'Поле ФИО должно начинаться с заглавной буквы и содержать только буквы и пробелы между инициалами.',

                'login.required' => 'Поле логина обязательно для заполнения.',
                'login.string' => 'Поле логина должно быть строкой.',
                'login.unique' => 'Такой логин уже зарегистрирован.',
                'login.max' => 'Поле логина должно быть не более 8 символов.',
                'login.regex' => 'Поле логина должно содержать только буквы и цифры.',

                'email.required' => 'Поле электронной почты обязательно для заполнения.',
                'email.string' => 'Поле электронной почты должно быть строкой.',
                'email.email' => 'Поле электронной почты должно быть действительным адресом.',
                'email.max' => 'Поле электронной почты должно быть не более 255 символов.',
                'email.unique' => 'Такой адрес электронной почты уже зарегистрирован.',

                'password.required' => 'Поле пароля обязательно для заполнения.',
                'password.string' => 'Поле пароля должно быть строкой.',
                'password.min' => 'Пароль должен содержать не менее 6 символов.',
                'password.max' => 'Пароль должен содержать не более 32 символов.',
                'password.regex' => 'Пароль должен содержать хотя бы одну цифру, одну заглавную букву и один специальный символ.',

                'address.required' => 'Поле адреса обязательно для заполнения.',
                'address.string' => 'Поле адреса должно быть строкой.',

                'dateOfBirth.required' => 'Поле даты рождения обязательно для заполнения.',
                'dateOfBirth.date' => 'Поле даты рождения должно быть датой.',
                'dateOfBirth.before_or_equal' => 'Вы должны быть старше 18 лет для регистрации.',

                'confirmPassword.required' => 'Поле для подтверждения пароля обязательно для заполнения.',
                'confirmPassword.string' => 'Поле для подтверждения пароля должно быть строкой.',
                'confirmPassword.same' => 'Пароль и его подтверждение должны совпадать.',

                'phoneNumber.required' => 'Поле номера телефона обязательно для заполнения.',
                'phoneNumber.string' => 'Поле номера телефона должно быть строкой.',
                'phoneNumber.regex' => 'Некорректный формат номера телефона. Пример: +7(999)999-99-99',
                'phoneNumber.unique' => 'Такой намер телефона уже зарегистрирован.',
            ]);

    // Проверка валидации
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $user = new User();
            $user->inn = $request->inn;
            $user->fullName = $request->fullName;
            $user->login = $request->login;
            $user->email = $request->email;
            $user->email_verified_at = null;
            $user->password = bcrypt($request->password);
            $user->remember_token = null;
            $user->address = $request->address;
            $user->phoneNumber = $request->phoneNumber;
            $user->dateOfBirth = date_create_from_format('d.m.Y', $request->dateOfBirth);
            $user->role_id = 2;
            $user->save();
            if (!$token = JWTAuth::attempt(['login'=> $request->login,'password' => $request->password])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Неккоректные данные',
                ], 401);
            }
            DB::table('role_user')->insert([
                'user_id' => $user->id,
                'role_id' => 2,
            ]);
            return response()->json([
                'success' => true,
                'data' => $user,
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ], 201);

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }


    public function logout(Request $request)
    {
        try {
            $token = $request->header('token'); // Получаем токен из заголовка запроса
            JWTAuth::invalidate(JWTAuth::parseToken($token));

            return response()->json([
                'status' => 'success',
                'message' => 'User logged out successfully'
            ]);
        }catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

    }

    public function getUser(Request $request)
    {
        try{
            $token = $request->header('token'); // Получаем токен из заголовка запроса
            $user = JWTAuth::authenticate($token);

            return response()->json([
                'success' => true,
                'user' => $user
            ]);

        }catch(\Exception $exception){
            return response()->json(['success'=>false,'message'=> $exception->getMessage()], 500);
        }
    }


    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'authorization' => [
                'token' => JWTAuth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

}
