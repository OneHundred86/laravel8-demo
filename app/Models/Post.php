<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property ?Image $image
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
}
