<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property int $id
 * @property ?Image $image
 * @property Collection $comments
 */
class Post extends Model
{
    use HasFactory;

    protected $fillable = ["title", "content"];
    public $timestamps = false;

    /**
     * 获取文章图片
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * 获取此文章的所有评论
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, "commentable");
    }
}
