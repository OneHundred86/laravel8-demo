<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Image;
use App\Models\Post;
use Tests\TestCase;

class MorphTest extends TestCase
{
    /**
     * 一对一 (多态)
     * @doc https://learnku.com/docs/laravel/10.x/eloquent-relationships/14889#35d89d
     * @return void
     */
    public function testOneToOne()
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

        //
        /** @var Image $image */
        $image = Image::query()->find(1);
        $imageAble = $image->imageable;
        // var_dump($imageAble);
        $this->assertEquals(1, $imageAble->id);
    }

    /**
     * 一对多（多态）
     * @return void
     */
    public function testOneToMany()
    {
        /** @var Post $post */
        $post = Post::query()->find(1);

        if ($post->comments->isEmpty()){
            foreach (["评论1", "评论2"] as $content){
                $post->comments()->create([
                    "content" => $content,
                ]);
            }

            $post->load("comments");
        }

        /** @var Comment $comment */
        foreach ($post->comments as $comment){
            // var_dump($comment->toArray());
            $this->assertEquals('App\Models\Post', $comment->commentable_type);
            $this->assertEquals(1, $comment->commentable_id);
        }
    }
}
