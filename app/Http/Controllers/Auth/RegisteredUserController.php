<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Регистрация пользователя",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "phone", "address", "password", "password_confirmation"},
     *             @OA\Property(property="name", type="string", example="Иван Петров"),
     *             @OA\Property(property="phone", type="string", example="79991234567"),
     *             @OA\Property(property="address", type="string", example="ул. Мясная, д.1"),
     *             @OA\Property(property="password", type="string", format="password", example="secret123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="secret123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Пользователь успешно зарегистрирован",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="1|xTY..."),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Иван Петров"),
     *                 @OA\Property(property="phone", type="string", example="79991234567"),
     *                 @OA\Property(property="address", type="string", example="ул. Мясная, д.1"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=422, description="Ошибка валидации")
     * )
     */
    public function store(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        $request->validated();

        $user = User::create([
            'name' => $request['name'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'password' => Hash::make($request['password']),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        event(new Registered($user));

        return response()->json([
            'token' => $token,
            'user' => $user,
        ], 201);
    }
}
