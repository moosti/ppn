<?php

namespace App\Http\Controllers\Api;

use App\Data\AuthData\LoginData;
use App\Data\AuthData\RegisterData;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(protected UserRepositoryInterface $userRepository) {}

    public function register(RegisterData $data)
    {
        $model = $this->userRepository->create($data);

        return UserResource::make($model);
    }

    public function login(LoginData $data): UserResource|JsonResponse
    {
        $user = $this->userRepository->findByCriteria(['email' => $data->email]);

        if (! $user || ! Hash::check($data->password, $user->password)) {
            return $this->apiResponse(400, message: __('Invalid email or password'));
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return $this->apiResponse(data: [
            'user' => UserResource::make($user)->resolve(),
            'token' => $token,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->apiResponse();
    }

    public function profile(): UserResource
    {
        $user = auth()->user();

        return UserResource::make($user);
    }
}
