<?php

namespace App\Repositories\BadgeRepository;

use App\Repositories\Generic\AddGetAllInterface;
use App\Repositories\Generic\AllInterface;
use App\Repositories\Generic\CreateInterface;
use App\Repositories\Generic\DeleteInterface;
use App\Repositories\Generic\FindDeleteInterface;
use App\Repositories\Generic\FindInterface;
use App\Repositories\Generic\UpdateInterface;

interface BadgeRepositoryInterface extends 
    CreateInterface, UpdateInterface, FindInterface, DeleteInterface, AllInterface
{
    public function findByNormalizedName(string $normalized_name);
}
