<?php

namespace App\Services\PostTypeService;

use Illuminate\Http\Request;

interface PostTypeServiceInterface
{
    public function addPostType(Request $request);
    public function updatePostType(Request $request);
    public function findPostType($id);
    public function deletePostType($id);
    public function all();
}
