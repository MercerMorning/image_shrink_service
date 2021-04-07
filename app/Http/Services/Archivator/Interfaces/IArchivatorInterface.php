<?php

namespace App\Http\Services\Archivator\Interfaces;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

interface IArchivatorInterface
{
    function __construct(File|UploadedFile $file, string $archiveType);

    public function createArchive();

    public function getPathname();
}
