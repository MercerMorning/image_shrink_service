<?php
namespace App\Http\Services\Archivator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;

class Archivator extends AbstractArchivator
{
    protected $fileUniqueName;
    protected $filePath;
    protected $archivePath;
    public $archiveType;

    //TODO:переименовывать файлы в архиваторе

    public function __construct(File $file,  $archiveType)
    {
        parent::__construct($file, $archiveType);
    }

    protected function zipArchivate()
    {
        $archivePath = 'app/archives/'.  $this->fileUniqueName . '.zip';
        $zip = new \ZipArchive();
        $zip->open(storage_path($archivePath), \ZipArchive::CREATE);
        $zip->addFile($this->filePath);
        $zip->close();
        $this->archivePath = storage_path($archivePath);
        return $this;
    }


}
