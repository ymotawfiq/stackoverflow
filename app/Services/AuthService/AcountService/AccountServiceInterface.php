<?php

namespace App\Services\AuthService\AccountService;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface AccountServiceInterface
{
    public function update_account(Request $request, $user) : JsonResponse;
    public function update_display_name(Request $request, $user) : JsonResponse;
    public function update_user_name(Request $request, $user) : JsonResponse;
}
