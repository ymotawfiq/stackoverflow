<?php

namespace App\Services\AuthService\LoginLogoutService;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface LoginLogoutServiceInterface
{
    public  function loginByEmail(Request $request) : JsonResponse;
    public  function loginByUserName(Request $request) : JsonResponse;
    public  function loginByIdOrUserNameOrEmail(Request $request) : JsonResponse;
    public function logout() : JsonResponse;
    public function reset2FACode($user);
}
