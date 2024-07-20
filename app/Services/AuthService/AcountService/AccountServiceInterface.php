<?php

namespace App\Services\AuthService\AccountService;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface AccountServiceInterface
{
    public function updateAccount(Request $request, $user) : JsonResponse;
    public function updateDisplayName(Request $request, $user) : JsonResponse;
    public function updateUserName(Request $request, $user) : JsonResponse;
}
