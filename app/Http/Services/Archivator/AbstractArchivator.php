<?php
namespace App\Http\Services\Archivator;

use App\Http\Services\Archivator\Interfaces\IArchivatorInterface;
use App\Jobs\DeletingFiles;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

abstract class AbstractArchivator implements IArchivatorInterface
{
    protected $filePath;
    protected $fileName;
    protected $archivePath;
    public $archiveType;

    function __construct(File $file, $archiveType)
    {
        $this->filePath = $file->getPathname();
        $this->fileName = $file->getFilename();
        $this->fileUniqueName = \Str::slug(pathinfo($this->fileName, PATHINFO_FILENAME)) .  Str::uuid();
        $this->archiveType = $archiveType;

//        if (in_array($archiveType, $this->allowedArchiveTypes)) {
//
//        }
    }

    public function getPathname()
    {
        return $this->archivePath;
    }

    public function createArchive($seconds = null)
    {
        $this->{$this->archiveType . 'Archivate'}();
        if ($seconds) {
//            \File::delete($this->archivePath);
            dispatch(new DeletingFiles($this->archivePath, $seconds));
        }
        return $this;
    }

}
