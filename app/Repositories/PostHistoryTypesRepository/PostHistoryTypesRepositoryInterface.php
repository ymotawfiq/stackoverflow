<?php

namespace App\Repositories\PostHistoryTypesRepository;
use App\Repositories\Generic\AddGetAllInterface;
use App\Repositories\Generic\FindDeleteInterface;
use App\Repositories\Generic\UpdateInterface;

interface PostHistoryTypesRepositoryInterface extends AddGetAllInterface, FindDeleteInterface, UpdateInterface
{
    public function find_by_normalized_name($name);
}
