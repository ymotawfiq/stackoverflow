<?php

namespace App\Repositories\UserBadgeRepository;

use App\Repositories\Generic\AddGetAllInterface;

interface UserBadgeRepositoryInterface extends AddGetAllInterface
{
    public function is_user_has_badge($data);
    public function remove_badge_from_user($data);
    public function get_user_badges($user_id);
}
