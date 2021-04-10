<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class UniqueName
{
    private $fileName;

    public static function generate(string $fileName, string $fileExt, callable $function = null)
    {
        return self::init()?->createNameWithoutExt($fileName)?->modifyName($function)?->addExt($fileExt)?->get();
    }

    private static function init()
    {
        return new self();
    }

    private function createNameWithoutExt(string $fileName)
    {
        $this->fileName = \Str::slug($fileName) .  Str::uuid();
        return $this;
    }

    private function modifyName(callable $function = null)
    {
        $this->fileName = $function ? $name = $function($this->fileName) : $this->fileName;
        return $this;
    }

    private function addExt(string $fileExt)
    {
        $this->fileName = $this->fileName . '.' . $fileExt;
        return $this;
    }
    private function get()
    {
        return $this->fileName;
    }
}