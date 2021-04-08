<?php
namespace App\Http\Services\Archivator;

use App\Http\Services\Archivator\Interfaces\IArchivatorInterface;
use App\Jobs\DeletingFiles;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

abstract class AbstractArchivator implements IArchivatorInterface
{
    protected $filePath;
    protected $fileName;
    protected $archivePath;
    protected $availableTypes = ['zip'];
    public $archiveType;

    function __construct(File|UploadedFile $file, string $archiveType)
    {
        $isUploaded = $file instanceof  UploadedFile;
        $this->filePath = $isUploaded ? $file->getRealPath() : $file->getPathname();
        $this->fileUniqueName = \Str::slug(pathinfo($isUploaded ? $file->getClientOriginalName() : $file->getFilename(), PATHINFO_FILENAME)) . '_' . Str::uuid();
        $this->archiveType = in_array($archiveType, $this->availableTypes) ? $archiveType : throw new \Exception('This archive type isnt available');
    }

    public function createArchive()
    {
        $methodName = $this->archiveType . 'Archivate';
        if (!method_exists($this,  $methodName)) throw new \Exception('Method doesnt exists');
        return $this->{$methodName}();
    }

    public function getPathname()
    {
        return $this->archivePath;
    }

    public function getFileName()
    {
        return $this->fileUniqueName;
    }



}
