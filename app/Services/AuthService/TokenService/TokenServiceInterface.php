<?php

namespace App\Services\AuthService\TokenService;

interface TokenServiceInterface
{
    public function generate_token($user);
    public function generate_token_non_2fa_user($user, $request);
}
