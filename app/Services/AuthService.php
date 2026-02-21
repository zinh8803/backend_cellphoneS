<?php

namespace App\Services;

use App\Helpers\ImageHelper;
use App\Models\RefreshToken;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Repositories\RefreshTokenRepository;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    protected $authRepository;
    protected $refreshTokenRepository;

    public function __construct(AuthRepository $authRepository, RefreshTokenRepository $refreshTokenRepository)
    {
        $this->authRepository = $authRepository;
        $this->refreshTokenRepository = $refreshTokenRepository;
    }

    public function getAll($params = [])
    {
        return $this->authRepository->all($params);
    }

    public function getByEmail($email)
    {
        return $this->authRepository->getByEmail($email);
    }

    public function register(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        $data['role_id'] = 2; // Default role_id for regular users
        $user = $this->authRepository->store($data);
        //  $token = $user->createToken('api_token')->plainTextToken;
        return [
            'user' => $user,
            // 'token' => $token,
        ];
    }

    public function login(array $credentials)
    {
        if (!$token = JWTAuth::attempt($credentials)) {
            return null;
        }

        $user = JWTAuth::user();
        $refreshToken = Str::random(64);
        $this->refreshTokenRepository->store([
            'token' => Hash::make($refreshToken),
            'user_id' => $user->id,
            'expires_at' => now()->addDays(30),
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
        ]);

        return [
            'token' => $token,
            'refresh_token' => $refreshToken,
        ];
    }

    public function refreshToken($refreshToken)
    {
        $storedToken = $this->refreshTokenRepository->getByToken($refreshToken);
        if (!$storedToken || $storedToken->expires_at < now()) {
            return null;
        }

        $user = $storedToken->user;
        $this->refreshTokenRepository->deleteById($storedToken->id);

        $newToken = JWTAuth::fromUser($user);
        $newRefreshToken = Str::random(64);
        $this->refreshTokenRepository->store([
            'token' => Hash::make($newRefreshToken),
            'user_id' => $user->id,
            'expires_at' => now()->addDays(30),
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
        ]);

        return [
            'token' => $newToken,
            'refresh_token' => $newRefreshToken,
        ];
    }

    public function logout(?string $refreshToken = null): bool
    {
        try {
            $user = Auth::guard('api')->user();
            if ($refreshToken) {
                $storedToken = $this->refreshTokenRepository->getByToken($refreshToken);
                if ($storedToken) {
                    $this->refreshTokenRepository->deleteById($storedToken->id);
                }
            } elseif ($user) {
                $this->refreshTokenRepository->deleteByUserId($user->id);
            }

            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (\Exception $e) {
            Log::warning('Logout failed', ['message' => $e->getMessage()]);
            return false;
        }
        return true;
    }

    public function getUser()
    {
        return Auth::guard('api')->user();
    }

    public function updateUSer($user, $data)
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile && $data['image']->isValid()) {
            try {
                $uploadResult = ImageHelper::uploadImage($data['image'], 'products');
                //  Log::info('Image uploaded successfully', ['image_url' => $uploadResult]);
                if (!empty($uploadResult) && !empty($uploadResult['url'])) {
                    $data['image_url'] = $uploadResult['url'];
                    $data['public_id'] = $uploadResult['public_id'] ?? null;
                }
                unset($data['image']);
            } catch (\Exception $e) {
                Log::error('Image upload failed', ['error' => $e->getMessage()]);
            }
        }
        $fields = ['name', 'phone', 'gender', 'image_url', 'public_id'];
        foreach ($fields as $field) {
            if (array_key_exists($field, $data)) {
                $user->$field = $data[$field];
            }
        }
        $user->save();
        return $user->fresh();
    }
}
