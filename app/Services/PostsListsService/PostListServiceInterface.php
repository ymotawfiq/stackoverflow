<?php

namespace App\Services\PostsListsService;

use App\Models\User;
use Illuminate\Http\Request;

interface PostListServiceInterface
{
    public function create(Request $request, User $user);
    public function update(Request $request, User $user);
    public function deleteById($list_id, User $user);
    public function findById($list_id, User $user);
    public function userLists(User $user);
}
