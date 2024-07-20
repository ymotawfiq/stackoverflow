<?php

namespace App\Services\AuthService\TokenService;

interface TokenServiceInterface
{
    public function generateToken($user);
    public function generateTokenForNon2FAUser($user, $request);
}
