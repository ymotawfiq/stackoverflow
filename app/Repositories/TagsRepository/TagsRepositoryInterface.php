<?php

namespace App\Repositories\TagsRepository;
use App\Repositories\Generic\AllInterface;
use App\Repositories\Generic\CreateInterface;
use App\Repositories\Generic\DeleteInterface;
use App\Repositories\Generic\FindInterface;
use App\Repositories\Generic\UpdateInterface;

interface TagsRepositoryInterface extends 
    CreateInterface, AllInterface, UpdateInterface, FindInterface, DeleteInterface
{
    public function findByNormalizedName($name);
}
