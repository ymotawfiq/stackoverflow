<?php

namespace App\Repositories\UserBadgeRepository;

use App\Repositories\Generic\AllInterface;
use App\Repositories\Generic\CreateInterface;

interface UserBadgeRepositoryInterface extends CreateInterface, AllInterface
{
    public function isUserHasBadge($data);
    public function removeBadgeFromUser($data);
    public function getUserBadges($user_id);
}
