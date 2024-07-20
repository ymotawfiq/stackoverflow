<?php

namespace App\Services\PostHistoryTypesService;

use App\Models\User;
use Illuminate\Http\Request;

interface PostHistoryTypesServiceInterface
{
    public function create(Request $request);
    public function update(Request $request);
    public function deleteById($id);
    public function findById($id);
    public function all();
}
