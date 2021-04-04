<?php

namespace App\Http\Services\Interfaces;


use Symfony\Component\HttpFoundation\File\File;

interface IArchivatorInterface
{
    function __construct(File $file);

    public function createArchive();

    public function getPathname();
}
