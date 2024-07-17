<?php

namespace App\Services\AuthService\ForgetResetPasswordService;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface ForgetResetPasswordServiceInterface
{
    public function generate_and_send_reset_password_code($user) : JsonResponse;
    public function reset_password_code($user);
    public function reset_password(Request $request) : JsonResponse;
    public function generate_and_send_reset_password_code_by_email(Request $request) : JsonResponse;
}
