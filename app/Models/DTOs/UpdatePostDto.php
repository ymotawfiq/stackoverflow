<?php

namespace App\Models\DTOs;

class UpdatePostDto
{
    public string $id = '';
    public string $title = '';
    public string $body = '';
    public string $post_type = '';

    public function __construct($id, $title, $body, $post_type){
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->post_type = $post_type;
    }


}
