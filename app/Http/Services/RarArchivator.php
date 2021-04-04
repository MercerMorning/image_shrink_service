<?php

namespace App\Http\Services;

use App\Http\Requests\ImageRequest;
use App\Http\Services\Interfaces\IArchivatorInterface;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

class RarArchivator extends AbstractArchivator
{
    public function __construct(UploadedFile $file)
    {
        parent::__construct($file);
    }
}
