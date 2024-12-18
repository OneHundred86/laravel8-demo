<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property ?Image $image
 * @property Collection $comments
 */
class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    // protected $fillable = ["title", "content"];
    protected $guarded = false;
    public $timestamps = true;

//    protected $casts =[
//        "created_at" => "datetime:Y-m-d H:i:s",
//    ];

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
