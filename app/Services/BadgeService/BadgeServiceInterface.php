<?php

namespace App\Services\BadgeService;

use Illuminate\Http\JsonResponse;

interface BadgeServiceInterface
{
    public function create($request) : JsonResponse;
    public function update($request) : JsonResponse;
    public function delete_by_id(string $id) : JsonResponse;
    public function find_by_id(string $id) : JsonResponse;
    public function all() : JsonResponse;
}
