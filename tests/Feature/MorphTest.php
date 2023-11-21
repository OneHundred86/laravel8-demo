<?php

namespace Tests\Feature;

use App\Models\Post;
use Tests\TestCase;

class MorphTest extends TestCase
{
    /**
     * 一对一 (多态)
     * @doc https://learnku.com/docs/laravel/10.x/eloquent-relationships/14889#35d89d
     * @return void
     */
    public function test_1to1()
    {
        /** @var Post $post */
        $post = Post::query()->firstOrCreate(["id" => 1], [
            "title" => "title1",
            "content" => "content1",
        ]);

        if(!$post->image){
            $post->image()->create([
                "url" => "http://post1.jpg",
            ]);
            $post->load("image");
        }

        // var_dump($post->image);
        $this->assertEquals('App\Models\Post', $post->image->imageable_type);
        $this->assertEquals(1, $post->image->imageable_id);
    }
}
