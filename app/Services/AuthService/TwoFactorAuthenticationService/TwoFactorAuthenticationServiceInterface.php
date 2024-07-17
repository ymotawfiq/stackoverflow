<?php

namespace App\Services\AuthService\TwoFactorAuthenticationService;

use Illuminate\Http\JsonResponse;

interface TwoFactorAuthenticationServiceInterface
{
    public function enable_two_factor_authentication($user) : JsonResponse;
    public function un_enable_two_factor_authentication($user) : JsonResponse;
}
