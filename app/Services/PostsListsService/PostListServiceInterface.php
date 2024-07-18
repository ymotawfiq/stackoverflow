<?php

namespace App\Services\PostsListsService;

use App\Models\User;
use Illuminate\Http\Request;

interface PostListServiceInterface
{
    public function create(Request $request, User $user);
    public function update(Request $request, User $user);
    public function delete_by_id($list_id, User $user);
    public function find_by_id($list_id, User $user);
    public function user_lists(User $user);
}
