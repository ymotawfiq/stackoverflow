<?php

namespace App\Models\DTOs;

class UpdatePostTypeDto
{
    public string $id;
    public string $post_type;

    public function __construct($id, $post_type){
        $this->id = $id;
        $this->post_type = $post_type;
    }
}
