<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class UniqueName
{
    public static function generate(string $fileName, string $fileExt, callable $function)
    {
        $name = \Str::slug($fileName) .  Str::uuid() . '.' . $fileExt;
        $name = $function($name);
        $name = $name . $fileExt;
        return $name;
    }

}