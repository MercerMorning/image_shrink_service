<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Http\Services\Archivator\Interfaces\IArchivatorInterface;
use App\Http\Services\Archivator\RarArchivator;
use App\Http\Services\Archivator\ZipArchivator;
use App\Http\Services\RequestResolver;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Str;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class ImageController extends Controller
{
    private $file;

    function __construct(ImageRequest $file)
    {
        $this->file = $file->file('image');
    }

    function optimize(ImageRequest $request) //TODO: Переименовать в optimize
    {
       $resolve = new RequestResolver();
       $result = $resolve->resolve($request);
       return response()->download($result->getPathName());
    }
}
