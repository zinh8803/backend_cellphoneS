<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthService
{
    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function getAll()
    {
        return $this->authRepository->getModel();
    }

    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $data['role_id'] = 2; // Default role_id for regular users
        $user = $this->authRepository->create($data);
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
        // $refreshToken = Str::random(60);
        // RefreshToken::create([
        //     'token' => $refreshToken,
        //     'user_id' => $user->id,
        //     'expires_at' => now()->addDays(30),
        //     'ip_address' => request()->ip(),
        //     'user_agent' => request()->header('User-Agent'),
        // ]);
        return [
            'token' => $token,
            'token_type' => 'bearer'
        ];
    }

    public function logout($user)
    {
        $user->currentAccessToken()->delete();
        return true;
    }
}
