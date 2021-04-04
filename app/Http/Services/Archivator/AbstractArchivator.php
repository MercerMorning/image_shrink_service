<?php
namespace App\Http\Services\Archivator;

use App\Http\Services\Archivator\Interfaces\IArchivatorInterface;
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

    public function getPathname()
    {
        return $this->archivePath;
    }
}
