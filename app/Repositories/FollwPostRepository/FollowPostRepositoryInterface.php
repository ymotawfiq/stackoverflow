<?php

namespace App\Repositories\FollwPostRepository;
use App\Repositories\Generic\AddGetAllInterface;
use App\Repositories\Generic\AllInterface;
use App\Repositories\Generic\CreateInterface;
use Illuminate\Http\Request;

interface FollowPostRepositoryInterface extends CreateInterface, AllInterface
{
    public function unFollowPost($post_id, $user_id);
    public function getUserFollowingPosts($user_id);
    public function getPostFollowingUsers($post_id);
    public function isUserFollowingPost($post_id, $user_id);
}
