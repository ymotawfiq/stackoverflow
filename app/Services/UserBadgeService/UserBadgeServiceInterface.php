<?php

namespace App\Services\UserBadgeService;

use Illuminate\Http\Request;

interface UserBadgeServiceInterface
{
    public function add_badge_to_user(Request $request);
    public function remove_badge_from_user(Request $request);
    public function is_user_has_badge(Request $request);
    public function get_user_badges($user_id);
}
