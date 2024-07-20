<?php

namespace App\Services\FollwPostService;

use App\Models\User;

interface FollowPostServiceInterface
{
    public function followPost($post_id, User $user);
    public function unFollowPost($post_id, User $user);
    public function findUserFollowingPosts($user_id);
    public function findPostFollowingUsers($post_id);
    public function isUserFollowingPost($post_id, User $user);
}
