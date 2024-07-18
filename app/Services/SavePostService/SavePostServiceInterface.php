<?php

namespace App\Services\SavePostService;

use App\Models\User;
use Illuminate\Http\Request;

interface SavePostServiceInterface
{
    public function savePost(Request $request, User $user);
    public function unSavePost($id, User $user);
    public function getUserSavedPostById($id, User $user);
    public function getUserSavedPosts(User $user);
    public function getUserSavedPostsByListId($list_id, User $user);
}
