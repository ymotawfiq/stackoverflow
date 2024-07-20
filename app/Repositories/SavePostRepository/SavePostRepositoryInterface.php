<?php

namespace App\Repositories\SavePostRepository;
use App\Repositories\Generic\AddGetAllInterface;
use App\Repositories\Generic\AllInterface;
use App\Repositories\Generic\CreateInterface;
use App\Repositories\Generic\DeleteInterface;
use App\Repositories\Generic\FindDeleteInterface;
use App\Repositories\Generic\FindInterface;
use App\Repositories\Generic\UpdateInterface;

interface SavePostRepositoryInterface extends 
    CreateInterface, AllInterface, FindInterface, DeleteInterface
{
    public function findUserSavedPostByIdUserId($id, $user_id);
    public function findUserSavedPostByListIdUserIdPostId($list_id, $user_id, $post_id);
    public function findUserSavedPosts($user_id);
    public function findUserSavedPostsByList($user_id, $list_id);
}
