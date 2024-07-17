<?php

namespace App\Repositories\Generic;

interface FindDeleteInterface
{
    public function delete_by_id($id);
    public function find_by_id($id);
}
