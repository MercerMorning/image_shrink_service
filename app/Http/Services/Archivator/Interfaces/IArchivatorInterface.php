<?php

namespace App\Http\Services\Archivator\Interfaces;


use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\File;

interface IArchivatorInterface
{
    function __construct(File $file, $archiveType);

    public function createArchive();

    public function getPathname();
}
