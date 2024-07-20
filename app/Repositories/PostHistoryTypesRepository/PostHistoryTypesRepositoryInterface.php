<?php

namespace App\Repositories\PostHistoryTypesRepository;
use App\Repositories\Generic\AllInterface;
use App\Repositories\Generic\CreateInterface;
use App\Repositories\Generic\DeleteInterface;
use App\Repositories\Generic\FindInterface;
use App\Repositories\Generic\UpdateInterface;

interface PostHistoryTypesRepositoryInterface extends 
    CreateInterface, AllInterface, UpdateInterface, FindInterface, DeleteInterface
{
    public function findByNormalizedType($normalized_type);
}
