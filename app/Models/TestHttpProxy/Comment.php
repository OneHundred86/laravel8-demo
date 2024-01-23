<?php

namespace App\Models\TestHttpProxy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
# use Illuminate\Database\Eloquent\Model;
use App\EloquentWithHttpProxy\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property Post | Video $commentable
 * @property int $commentable_id
 * @property string $commentable_type
 */
class Comment extends Model
{
    use HasFactory;
    protected $connection = "httpproxy";
    protected $fillable = ["content"];
    public $timestamps = false;

    public function commentable(): MorphMany
    {
        return $this->morphTo();
    }
}
