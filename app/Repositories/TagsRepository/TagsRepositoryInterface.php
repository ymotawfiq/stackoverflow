<?php

namespace App\Repositories\TagsRepository;
use App\Repositories\Generic\AddGetAllInterface;
use App\Repositories\Generic\FindDeleteInterface;
use App\Repositories\Generic\UpdateInterface;

interface TagsRepositoryInterface extends AddGetAllInterface, UpdateInterface, FindDeleteInterface
{
    
}
