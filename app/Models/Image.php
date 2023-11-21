<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string $url
 * @property int $imageable_id
 * @property string $imageable_type
 */
class Image extends Model
{
    use HasFactory;

    protected $fillable = ["url"];
    public $timestamps = false;


    /**
     * 获取父级 imageable 模型（用户或帖子）。
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
