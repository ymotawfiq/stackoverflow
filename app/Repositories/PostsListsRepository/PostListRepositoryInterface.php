<?php

namespace App\Repositories\PostsListsRepository;
use App\Repositories\Generic\AddGetAllInterface;
use App\Repositories\Generic\FindDeleteInterface;
use App\Repositories\Generic\UpdateInterface;

interface PostListRepositoryInterface extends AddGetAllInterface, FindDeleteInterface, UpdateInterface
{
    public function find_user_lists($user_id);
    public function find_by_name($name, $user_id);
    public function find_list_by_id_user_id($id, $user_id);
}
