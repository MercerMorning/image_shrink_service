<?php

namespace App\Http\Services;

use App\Http\Requests\ImageRequest;
use App\Http\Services\Interfaces\IArchivatorInterface;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

abstract class AbstractArchivator implements IArchivatorInterface
{
    protected $filePath;
    protected $fileName;
    protected $archivePath;

    function __construct(File $file)
    {
        $this->filePath = $file->getPathname();
        $this->fileName = $file->getFilename();
        $this->fileUniqueName = \Str::slug(pathinfo($this->fileName, PATHINFO_FILENAME)) .  Str::uuid();
    }

    public function getArchivePath()
    {
//        if (empty($this->archivePath)) throw new \Exception('archive is not set');
//        return response()->download($this->archivePath);
        return $this->archivePath;
    }

    public function getPathname()
    {
        return $this->archivePath;
    }
}
