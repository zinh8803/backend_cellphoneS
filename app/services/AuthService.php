<?php

namespace App\Services;

use App\Models\RefreshToken;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Repositories\RefreshTokenRepository;

class AuthService
{
    protected $authRepository;
    protected $refreshTokenRepository;

    public function __construct(AuthRepository $authRepository, RefreshTokenRepository $refreshTokenRepository)
    {
        $this->authRepository = $authRepository;
        $this->refreshTokenRepository = $refreshTokenRepository;
    }

    public function getAll()
    {
        return $this->authRepository->all();
    }

    public function getByEmail($email)
    {
        return $this->authRepository->getByEmail($email);
    }

    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
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
        $token = Auth::guard('api')->attempt($credentials);
        if (!$token) {
            return null;
        }
        $refreshToken = Str::random(60);
        $this->refreshTokenRepository->store([
            'token' => $refreshToken,
            'user_id' => Auth::guard('api')->user()->id,
            'expires_at' => now()->addDays(30),
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
        ]);

        return [
            'token' => $token,
            'refresh_token' => $refreshToken,
        ];
    }

    public function logout(): bool
    {
        Auth::guard('api')->logout();
        return true;
    }
}
