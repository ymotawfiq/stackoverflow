<?php

namespace App\Services\PostService;

use App\Models\DTOs\UpdatePostDto;
use App\Models\User;
use Illuminate\Http\Request;

interface PostServiceInterface
{
    public function create(Request $request, User $user);
    public function update(Request $request, User $user);
    public function findById($post_id);
    public function deleteById($post_id, User $user);
    public function allPosts();
    public function allUserPosts($user_id_user_name_email);
    public function updatePostTitle(Request $request, User $user);
    public function updatePostBody(Request $request, User $user);
    public function updatePostType(Request $request, User $user);
    public function updatePostTitleAndBody(Request $request, User $user);
}
