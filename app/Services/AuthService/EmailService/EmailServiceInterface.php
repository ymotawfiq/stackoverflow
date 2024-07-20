<?php

namespace App\Services\AuthService\EmailService;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface EmailServiceInterface
{
    public function resendEmailVerificationLink(Request $request) : JsonResponse;
}
