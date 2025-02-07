<?php

namespace App\Models;


class File extends \Oh86\UploadFile\Models\File
{
    protected $visible = [
        'id',
        'name',
        'size',
    ];
}