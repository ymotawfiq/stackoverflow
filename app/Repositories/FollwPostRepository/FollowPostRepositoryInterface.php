<?php

namespace App\Repositories\FollwPostRepository;
use App\Repositories\Generic\AddGetAllInterface;
use Illuminate\Http\Request;

interface FollowPostRepositoryInterface extends AddGetAllInterface
{
    public function un_follow_post($post_id, $user_id);
    public function get_user_following_posts($user_id);
    public function get_post_following_users($post_id);
    public function is_user_following_post($post_id, $user_id);
}
