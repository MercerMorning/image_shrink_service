<?php

namespace App\Http\Services\Interfaces;

use Illuminate\Http\UploadedFile;

interface IArchivatorInterface
{
    function __construct(UploadedFile $file);

    public function createArchive();

    public function getArchive();
}
