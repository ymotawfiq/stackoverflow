<?php

namespace App\Services\FollwPostService;

use App\Models\User;
use Illuminate\Http\Request;

interface FollowPostServiceInterface
{
    public function follow_post($post_id, User $user);
    public function un_follow_post($post_id, User $user);
    public function find_user_following_posts($user_id);
    public function find_post_following_users($post_id);
    public function is_user_following_post($post_id, User $user);
}
