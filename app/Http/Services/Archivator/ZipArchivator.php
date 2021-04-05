<?php
namespace App\Http\Services\Archivator;

use Symfony\Component\HttpFoundation\File\File;

class ZipArchivator extends AbstractArchivator
{
    protected $fileName;
    protected $fileUniqueName;
    protected $filePath;
    protected $fileExt;
    protected $archivePath;
    protected $fileTmp;

    public function __construct(File $file)
    {
        $this->fileTmp = $file->getRealPath();
        parent::__construct($file);
    }

    public function createArchive()
    {
        $filePath = public_path('archive/' . $this->fileUniqueName . ".zip");
        $zip = new \ZipArchive(); //Создаём объект для работы с ZIP-архивами
        $zip->open($filePath, \ZipArchive::CREATE); //Открываем (создаём) архив archive.zip
        $zip->addFile($this->filePath, $this->fileName, flags: \ZipArchive::FL_NODIR);
        $zip->close();
        $this->archivePath = $filePath;
        return $this;
    }


}
