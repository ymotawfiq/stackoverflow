<?php

namespace App\Repositories\SavePostRepository;
use App\Repositories\Generic\AddGetAllInterface;
use App\Repositories\Generic\FindDeleteInterface;
use App\Repositories\Generic\UpdateInterface;

interface SavePostRepositoryInterface extends AddGetAllInterface, FindDeleteInterface
{
    public function find_user_saved_post_by_id_user_id($id, $user_id);
    public function find_user_saved_post_by_list_id_user_id_post_id($list_id, $user_id, $post_id);
    public function find_user_saved_posts($user_id);
    public function find_user_saved_posts_by_list($user_id, $list_id);
}
