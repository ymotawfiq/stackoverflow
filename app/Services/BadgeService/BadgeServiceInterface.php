<?php

namespace App\Services\BadgeService;

use Illuminate\Http\JsonResponse;

interface BadgeServiceInterface
{
    public function create($request) : JsonResponse;
    public function update($request) : JsonResponse;
    public function deleteById(string $id) : JsonResponse;
    public function findById(string $id) : JsonResponse;
    public function all() : JsonResponse;
}
