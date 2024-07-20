<?php

namespace App\Services\PostHistoryTypesService;

use App\Models\User;
use Illuminate\Http\Request;

interface PostHistoryTypesServiceInterface
{
    public function create(Request $request);
    public function update(Request $request);
    public function delete_by_id($id);
    public function find_by_id($id);
    public function all();
}
