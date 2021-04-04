<?php

namespace App\Http\Services\Archivator\Interfaces;


use Symfony\Component\HttpFoundation\File\File;

interface IArchivatorInterface
{
    function __construct(File $file);

    public function createArchive();

    public function getPathname();
}
