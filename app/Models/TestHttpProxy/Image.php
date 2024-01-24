<?php

namespace App\Models\TestHttpProxy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
# use Illuminate\Database\Eloquent\Model;
use App\EloquentWithHttpProxy\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property string $url
 * @property int $imageable_id
 * @property string $imageable_type
 * @property Post | User $imageable
 */
class Image extends Model
{
    use HasFactory;
    protected $connection = "httpproxy";
    protected $fillable = ["url"];
    public $timestamps = false;


    /**
     * 获取父级 imageable 模型（用户或帖子）。
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    public function post()
    {
        return $this->belongsTo(Post::class, "imageable_id");
    }
}
