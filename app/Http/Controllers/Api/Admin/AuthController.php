<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterUser;
use App\Http\Requests\Auth\UpdateAuthRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
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
        ])->cookie('token', $result['token'], 60 * 24, null, null, false, true);
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

    /**
     * @OA\Get(
     *     path="/api/auth/user",
     *     summary="Lấy thông tin người dùng hiện tại",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=200,
     *         description="Thông tin người dùng",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     */
    public function getUser(Request $request)
    {
        if (!$request->bearerToken() && $request->hasCookie('token')) {
            $token = $request->cookie('token');
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }
        $user = $this->authService->getUser();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return response()->json(new UserResource($user), 200);
    }

    /**
     * @OA\Post (
     *     path="/api/auth/user",
     *     summary="Cập nhật thông tin người dùng hiện tại",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/UpdateAuthRequest")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function updateUser(UpdateAuthRequest $request)
    {
        $user = $this->authService->getUser();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $data = $request->only(['name', 'phone', 'gender', 'image']);
        $updatedUser = $this->authService->updateUSer($user, $data);
        return response()->json(new UserResource($updatedUser), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Đăng xuất người dùng",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=200,
     *         description="Đăng xuất thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logged out successfully")
     *         )
     *     )
     * )
     */

    public function logout(Request $request)
    {
        $this->authService->logout();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
