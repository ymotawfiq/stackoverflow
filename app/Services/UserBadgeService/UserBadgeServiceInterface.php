<?php

namespace App\Services\UserBadgeService;

use Illuminate\Http\Request;

interface UserBadgeServiceInterface
{
    public function addBadgeToUser(Request $request);
    public function removeBadgeFromUser(Request $request);
    public function isUserHasBadge(Request $request);
    public function getUserBadges($user_id);
}
