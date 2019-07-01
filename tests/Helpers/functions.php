<?php

use App\Post;

function createPost($attributes = [])
{
    return factory(Post::class)->create($attributes);
}