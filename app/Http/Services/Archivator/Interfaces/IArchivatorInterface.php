<?php

namespace App\Http\Services\Archivator\Interfaces;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\File;

interface IArchivatorInterface
{
    function __construct(File $file, $archiveType);

    public function createArchive( $seconds);

    public function getPathname();
}
