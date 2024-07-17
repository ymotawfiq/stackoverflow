<?php

namespace App\Services\AuthService\LoginLogoutService;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface LoginLogoutServiceInterface
{
    public  function login_by_email(Request $request) : JsonResponse;
    public  function login_by_user_name(Request $request) : JsonResponse;
    public  function login_by_id_or_userName_or_email(Request $request) : JsonResponse;
    public function logout() : JsonResponse;
    public function reset_2fa_code($user);
}
