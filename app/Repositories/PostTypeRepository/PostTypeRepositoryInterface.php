<?php

namespace App\Repositories\PostTypeRepository;

use App\Repositories\Generic\AddGetAllInterface;
use App\Repositories\Generic\AllInterface;
use App\Repositories\Generic\CreateInterface;
use App\Repositories\Generic\DeleteInterface;
use App\Repositories\Generic\FindDeleteInterface;
use App\Repositories\Generic\FindInterface;
use App\Repositories\Generic\UpdateInterface;

interface PostTypeRepositoryInterface extends
    CreateInterface, AllInterface, UpdateInterface, FindInterface, DeleteInterface
{
    public function findByNormalizedType($normalized_type);
}
