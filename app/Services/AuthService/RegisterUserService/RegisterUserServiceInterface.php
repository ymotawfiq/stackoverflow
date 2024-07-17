<?php

namespace App\Services\AuthService\RegisterUserService;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface RegisterUserServiceInterface
{
    public  function register(Request $request) : JsonResponse;
    public function get_current_user() : JsonResponse;
    public function get_user(Request $request) : JsonResponse;
}
