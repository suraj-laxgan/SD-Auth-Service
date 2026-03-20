<?php

namespace App\Services;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Jobs\WelcomeEmailJob;
use App\Events\UserRegisteredEvent;
class AuthService
{
    protected $userRepo;

    public function __construct(BaseRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->userRepo->create($data);
        // WelcomeEmailJob::dispatch($user); //Normaly send job directly which is light coupling
        event(new UserRegisteredEvent($user));
        return $user;
    }

    public function FindByEmail(string $email)
    {
        return $this->userRepo->FindByEmail($email);
    }

    public function logout()
    {
        return JWTAuth::invalidate(JWTAuth::getToken());
    }

    public function findMe()
    {
        return JWTAuth::user();
    }

    public function refreshToken()
    {
        return JWTAuth::parseToken()->refresh();
    }
    public function tokengenerate($token)
    {
         $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
            'user_name' => JWTAuth::user()->name,
        ];
        return $data;
    }
}
