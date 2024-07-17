<?php

namespace App\Services\PostTypeService;

use Illuminate\Http\Request;

interface PostTypeServiceInterface
{
    public function add_post_type(Request $request);
    public function update_post_type(Request $request);
    public function find_post_type($id);
    public function delete_post_type($id);
    public function all();
}
