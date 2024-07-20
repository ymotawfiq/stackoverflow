<?php

namespace App\Repositories\PostsListsRepository;
use App\Repositories\Generic\AddGetAllInterface;
use App\Repositories\Generic\AllInterface;
use App\Repositories\Generic\CreateInterface;
use App\Repositories\Generic\DeleteInterface;
use App\Repositories\Generic\FindDeleteInterface;
use App\Repositories\Generic\FindInterface;
use App\Repositories\Generic\UpdateInterface;

interface PostListRepositoryInterface extends 
    CreateInterface, FindInterface, UpdateInterface, DeleteInterface, AllInterface
{
    public function findUserLists($user_id);
    public function findByName($name, $user_id);
    public function findListByIdUserId($id, $user_id);
}
