<?php

namespace App\Http\Services;

use App\Http\Requests\ImageRequest;
use App\Http\Services\Interfaces\IArchivatorInterface;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

class ZipArchivator extends AbstractArchivator
{
    protected $tmpName;
    protected $fileName;
    protected $fileUniqueName;
    protected $filePath;
    protected $fileExt;
    protected $archivePath;

    public function __construct(File $file)
    {
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
