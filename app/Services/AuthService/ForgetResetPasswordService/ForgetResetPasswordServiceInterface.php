<?php

namespace App\Services\AuthService\ForgetResetPasswordService;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface ForgetResetPasswordServiceInterface
{
    public function generateAndSendResetPasswordCode($user) : JsonResponse;
    public function resetPasswordCode($user);
    public function resetPassword(Request $request) : JsonResponse;
    public function generateAndSendResetPasswordCodeByEmail(Request $request) : JsonResponse;
}
