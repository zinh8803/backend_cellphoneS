<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RefreshTokenRequest;
use App\Http\Requests\Auth\RegisterUser;
use App\Http\Requests\Auth\UpdateAuthRequest;
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
    public function getAllUser(Request $request)
    {
        $users = $this->authService->getAll($request->all());
        return response()->json([
            'items' => UserResource::collection(collect($users['items'])),
            'paginate' => $users['paginate'] ?? null,
        ], 200);
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
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="OK"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="refreshToken", type="string", example="refresh.token.here"),
     *                 @OA\Property(property="roleId", type="integer", example=1),
     *                 @OA\Property(property="tokenType", type="string", example="bearer")
     *             ),
     *             @OA\Property(property="errors", type="object", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Đăng nhập thất bại",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=401),
     *             @OA\Property(property="message", type="string", example="Incorrect account or password"),
     *             @OA\Property(property="data", type="object", nullable=true),
     *             @OA\Property(property="errors", type="object", nullable=true)
     *         )
     *     )
     * )
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $result = $this->authService->login($credentials);
        if (!$result) {
            return response()->json(['message' => 'Incorrect account or password'], 401);
        }
        $user = $this->authService->getByEmail($credentials['email']);
        $role_id = $user ? $user->role_id : null;
        $cookieSecure = $request->isSecure() || (bool) config('session.secure');
        return response()->json([
            'refresh_token' => $result['refresh_token'],
            'role_id' => $role_id,
            'token_type' => 'bearer'
        ])->cookie('token', $result['token'], 60 * 24, '/', null, $cookieSecure, true, false, 'Strict');
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
     * @OA\Post(
     *     path="/api/auth/refresh-token",
     *     summary="Làm mới token bằng refresh token",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="refresh_token", type="string", example="refresh.token.here")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Làm mới token thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="OK"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="token", type="string", example="new.jwt.token.here"),
     *                 @OA\Property(property="refreshToken", type="string", example="new.refresh.token.here")
     *             ),
     *             @OA\Property(property="errors", type="object", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Refresh token không hợp lệ hoặc đã hết hạn",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=401),
     *             @OA\Property(property="message", type="string", example="Invalid or expired refresh token"),
     *             @OA\Property(property="data", type="object", nullable=true),
     *             @OA\Property(property="errors", type="object", nullable=true)
     *         )
     *     )
     * )
     */
    public function refreshToken(RefreshTokenRequest $request)
    {
        $refreshToken = $request->input('refresh_token');
        $result = $this->authService->refreshToken($refreshToken);
        if (!$result) {
            return response()->json(['message' => 'Invalid or expired refresh token'], 401);
        }
        $cookieSecure = $request->isSecure() || (bool) config('session.secure');
        return response()->json($result, 200)->cookie('token', $result['token'], 60 * 24, '/', null, $cookieSecure, true, false, 'Strict');
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
     * @OA\Put (
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
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Logged out successfully"),
     *             @OA\Property(property="data", type="object", nullable=true),
     *             @OA\Property(property="errors", type="object", nullable=true)
     *         )
     *     )
     * )
     */

    public function logout(Request $request)
    {
        $this->authService->logout($request->input('refresh_token'));
        return response()->json(['message' => 'Logged out successfully']);
    }
}
