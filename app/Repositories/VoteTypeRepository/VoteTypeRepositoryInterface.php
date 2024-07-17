<?php

namespace App\Repositories\VoteTypeRepository;
use App\Repositories\Generic\AddGetAllInterface;
use App\Repositories\Generic\FindDeleteInterface;
use App\Repositories\Generic\UpdateInterface;

interface VoteTypeRepositoryInterface extends AddGetAllInterface, FindDeleteInterface, UpdateInterface
{
    public function find_by_normalized_type($normalized_type);
}
