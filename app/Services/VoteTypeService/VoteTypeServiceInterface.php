<?php

namespace App\Services\VoteTypeService;

use Illuminate\Http\Request;

interface VoteTypeServiceInterface
{
    public function add_vote_type(Request $request);
    public function update_vote_type(Request $request);
    public function delete_by_id($id);
    public function find_by_id($id);
    public function all_vote_types();
}
