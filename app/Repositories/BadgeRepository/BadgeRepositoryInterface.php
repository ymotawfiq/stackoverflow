<?php

namespace App\Repositories\BadgeRepository;

use App\Repositories\Generic\AddGetAllInterface;
use App\Repositories\Generic\FindDeleteInterface;
use App\Repositories\Generic\UpdateInterface;

interface BadgeRepositoryInterface extends AddGetAllInterface, UpdateInterface, FindDeleteInterface
{
    public function find_by_normalized_name(string $normalized_name);
}
