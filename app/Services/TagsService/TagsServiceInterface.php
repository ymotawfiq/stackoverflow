<?php

namespace App\Services\TagsService;

use Illuminate\Http\Request;

interface TagsServiceInterface
{
    public function create(Request $request);
    public function update(Request $request);
    public function deleteById($tag_id);
    public function findById($tag_id);
    public function findByName($name);
    public function all();
}
