<?php

namespace App\Http\Services;

use App\Http\Requests\ImageRequest;
use App\Http\Services\Interfaces\IArchivatorInterface;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

abstract class AbstractArchivator implements IArchivatorInterface
{
    protected $tmpName;
    protected $fileName;
    protected $fileUniqueName;
    protected $filePath;
    protected $fileExt;
    protected $archivePath;

    function __construct(UploadedFile $file)
    {
        $this->tmpName = $file->getFilename();
        $this->fileName = \Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $this->fileUniqueName = $this->fileName . \Str::uuid();
        $this->filePath = $file->getRealPath();
        $this->fileExt =  $file->getClientOriginalExtension();
    }

    public function getArchive()
    {
        if (empty($this->archivePath)) throw new \Exception('archive is not set');
        return response()->download($this->archivePath);
    }

    public function createArchive()
    {
        // TODO: Implement createArchive() method.
    }
}
