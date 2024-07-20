<?php

namespace App\Services\PostHistoryTypesService;

use App\Models\User;
use Illuminate\Http\Request;

interface PostHistoryTypesServiceInterface
{
    public function create(Request $request, User $user);
    public function update(Request $request, User $user);
    public function delete_by_id($id, User $user);
    public function find_by_id($id);
    public function all();
}
