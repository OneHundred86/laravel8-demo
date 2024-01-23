<?php

namespace App\Models\TestHttpProxy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
# use Illuminate\Database\Eloquent\Model;
use App\EloquentWithHttpProxy\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "posts";
    protected $connection = "httpproxy";
    // public $timestamps = false;

    protected $guarded = [];


    /**
     * 获取文章图片
     */
    public function image(): MorphOne
    {
        // return $this->morphOne(Image::class, 'imageable', "imageable_type", "imageable_id", "id");
        // return $this->morphOne(Image::class, 'imageable', null, null, "id");

        // 效果和上面一样
        return $this->morphOne(Image::class, "imageable");
    }

    /**
     * 获取此文章的所有评论
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, "commentable");
    }
}
