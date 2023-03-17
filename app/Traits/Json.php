<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait Json
{
    public static function create($filename, $arr)
    {
        Storage::disk("s3")->put("/" . $filename, json_encode($arr), "public");
    }
}
