<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
# use Illuminate\Database\Eloquent\Model;
use App\EloquentWithHttpProxy\Eloquent\Model;

class TestHttpProxy extends Model
{
    use HasFactory;
    protected $table = "posts";
    protected $connection = "httpproxy";
    public $timestamps = false;

    protected $guarded = [];
}
