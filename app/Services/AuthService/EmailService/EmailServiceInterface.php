<?php

namespace App\Services\AuthService\EmailService;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface EmailServiceInterface
{
    public function resend_email_verification_link(Request $request) : JsonResponse;
}
