<?php

namespace App\Services\VoteTypeService;

use Illuminate\Http\Request;

interface VoteTypeServiceInterface
{
    public function addVoteType(Request $request);
    public function updateVoteType(Request $request);
    public function deleteById($id);
    public function findById($id);
    public function allVoteTypes();
}
