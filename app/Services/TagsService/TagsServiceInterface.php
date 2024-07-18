<?php

namespace App\Services\TagsService;

use Illuminate\Http\Request;

interface TagsServiceInterface
{
    public function create(Request $request);
    public function update(Request $request);
    public function delete_by_id($tag_id);
    public function find_by_id($tag_id);
    public function find_by_name($name);
    public function all();
}
