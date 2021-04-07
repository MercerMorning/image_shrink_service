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
//        dd( public_path('archive/' . $this->fileUniqueName . ".zip"));
//        $archivePath = public_path('archive/' . 'file' . ".zip");
        $archivePath = 'app/archives/'.  $this->fileUniqueName . '.zip';
//        dd($archivePath);
        $zip = new \ZipArchive(); //Создаём объект для работы с ZIP-архивами
//        $zip->open($filePath, \ZipArchive::CREATE); //Открываем (создаём) архив archive.zip]
//        $zip->open($archivePath, \ZipArchive::CREATE); //Открываем (создаём) архив archive.zip]
        $zip->open(storage_path($archivePath), \ZipArchive::CREATE); //Открываем (создаём) архив archive.zip]
            $zip->addFile($this->filePath);
        $zip->addEmptyDir('dir');
        $zip->close();
        $this->archivePath = storage_path($archivePath);
        return $this;
    }


}
