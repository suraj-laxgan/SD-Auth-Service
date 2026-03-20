<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Constants\HttpStatusCode;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegistrationRequest $request)
    {
        $user = $this->authService->register($request->all());
        return $this->outputResponse($user, "User registered successfully", HttpStatusCode::OK);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->authenticate();
        return $this->outputResponse($data, "User login successfully", HttpStatusCode::OK);
    }


    public function logout()
    {
        $this->authService->logout();
        return $this->outputResponse('', "User logged out successfully", HttpStatusCode::OK);
    }

    public function me()
    {
        $user = $this->authService->findMe();
        return $this->outputResponse($user, "Data fetch successfully", HttpStatusCode::OK);
    }

    public function FindByEmail(Request $request)
    {
        $user = $this->authService->FindByEmail($request->email);
        return $this->outputResponse($user, "Data fetch successfully", HttpStatusCode::OK);
    }

    public function refresh()
    {
        $newToken = $this->authService->refreshToken();
        $data = $this->respondWithToken($newToken);
        return $this->outputResponse($data, "Token refresh successfully", HttpStatusCode::OK);
    }

    protected function respondWithToken($token)
    {
        return $this->authService->tokengenerate($token);
    }
}
