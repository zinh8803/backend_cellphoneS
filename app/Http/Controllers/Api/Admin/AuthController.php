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

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Đăng nhập người dùng",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),   
     *            @OA\Property(property="password", type="string", format="password", example="password123")
     *        )
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="Đăng nhập thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="refresh_token", type="string", example="refresh.token.here"),
     *             @OA\Property(property="role_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Đăng nhập thất bại",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Incorrect account or password")
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $result = $this->authService->login($credentials);
        if (!$result) {
            return response()->json(['message' => 'Incorrect account or password'], 401);
        }
        $user = $this->authService->getByEmail($credentials['email']);
        $role_id = $user ? $user->role_id : null;
        return response()->json([
            'refresh_token' => $result['refresh_token'],
            'role_id' => $role_id,
            'token_type' => 'bearer'
        ])->cookie('token', $result['token'], 60 * 24, null, null, false, true, false, 'Strict');
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
