<?php

namespace App\Services\AuthService\RegisterUserService;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface RegisterUserServiceInterface
{
    public  function register(Request $request) : JsonResponse;
    public function getCurrentUser() : JsonResponse;
    public function getUser(Request $request) : JsonResponse;
}
