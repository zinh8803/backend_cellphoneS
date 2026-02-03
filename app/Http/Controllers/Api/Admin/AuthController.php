<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterUser;
use App\Services\AuthService;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Quản lý xác thực người dùng"
 * )
 */
class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @OA\Get(
     *     path="/api/auth/users",
     *     summary="Lấy danh sách tất cả người dùng",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách người dùng",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     )
     * )
     */
    public function getAllUser()
    {
        $users = $this->authService->getAll();
        return response()->json($users, 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $result = $this->authService->login($credentials);
        if (!$result) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return response()->json($result);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     summary="Đăng ký người dùng",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RegisterRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Đăng ký thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Đăng ký thành công"),
     *             @OA\Property(property="token", type="string", example="jwt.token.here"),
     *             @OA\Property(property="data", ref="#/components/schemas/User")
     *         )
     *     )
     * )
     */
    public function register(RegisterUser $request)
    {
        $data = $request->only(['name', 'email', 'password']);
        $result = $this->authService->register($data);
        return response()->json($result, 201);
    }


    public function logout(Request $request)
    {
        $this->authService->logout();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
