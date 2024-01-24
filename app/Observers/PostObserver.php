<?php

namespace App\Observers;

use App\Models\TestHttpProxy\Post;

class PostObserver
{
    /**
     * @param Post $post
     */
    public function saved($post)
    {
        var_dump(__METHOD__, $post->id);
    }
}
