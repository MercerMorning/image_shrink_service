<?php
namespace App\Http\Services\Archivator;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\File;

class Archivator extends AbstractArchivator
{
    protected $fileName;
    protected $fileUniqueName;
    protected $filePath;
    protected $fileExt;
    protected $archivePath;
    protected $archiveType;
    protected $allowedArchiveTypes = ['zip'];//TODO: вынести в конфиг

    public function __construct(File $file,  $archiveType)
    {
//        $archive = match ($request->input('archiveType')) {
//            'zip' => new ZipArchivator($file), //TODO: Вынести в общий архиватор
//            default => throw new \Exception('Unexpected match value')
//        };

        parent::__construct($file, $archiveType);
        //TODO: проверить наличие метода
    }

    protected function zipArchivate()
    {
        $filePath = public_path('archive/' . $this->fileUniqueName . ".zip");
        $zip = new \ZipArchive(); //Создаём объект для работы с ZIP-архивами
        $zip->open($filePath, \ZipArchive::CREATE); //Открываем (создаём) архив archive.zip
        $zip->addFile( $this->filePath, $this->fileName, flags: \ZipArchive::FL_NODIR);
        $zip->close();
        $this->archivePath = $filePath;
        return $this;
    }


}
