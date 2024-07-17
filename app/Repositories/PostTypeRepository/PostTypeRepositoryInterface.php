<?php

namespace App\Repositories\PostTypeRepository;

use App\Repositories\Generic\AddGetAllInterface;
use App\Repositories\Generic\FindDeleteInterface;
use App\Repositories\Generic\UpdateInterface;

interface PostTypeRepositoryInterface extends AddGetAllInterface, FindDeleteInterface, UpdateInterface
{
    public function find_by_normalized_type($normalized_type);
}
