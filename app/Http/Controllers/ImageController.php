<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArchiveTypeRequest;
use App\Http\Requests\ImageRequest;
use App\Http\Services\ImageShrink;
use App\Http\Services\Interfaces\IArchivatorInterface;
use App\Http\Services\RarArchivator;
use App\Http\Services\ZipArchivator;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

class ImageController extends Controller
{
    private $file;

    function __construct(ImageRequest $file)
    {
        $this->file = $file->file('image');
    }

    function shrink(Request $archiveType)
    {
        $archivator = match ($archiveType->input('archiveType')) {
            'zip' => new ZipArchivator($this->file),
            'rar' => new RarArchivator($this->file),
            default => throw new \Exception('Unexpected match value')
        };
        if (!$archivator instanceof IArchivatorInterface) throw new \Exception('Archivator doesnt implement correct contract');

        $archivator->createArchive();
        return $archivator->getArchive();
    }
}
