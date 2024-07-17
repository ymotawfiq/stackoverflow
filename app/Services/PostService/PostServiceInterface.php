<?php

namespace App\Services\PostService;

use App\Models\DTOs\UpdatePostDto;
use App\Models\User;
use Illuminate\Http\Request;

interface PostServiceInterface
{
    public function create(Request $request, User $user);
    public function update(Request $request, User $user);
    public function find_by_id($post_id);
    public function delete_by_id($post_id, User $user);
    public function all_posts();
    public function all_user_posts($user_id_user_name_email);
    public function update_post_title(Request $request, User $user);
    public function update_post_body(Request $request, User $user);
    public function update_post_type(Request $request, User $user);
    public function update_post_title_and_body(Request $request, User $user);
}
