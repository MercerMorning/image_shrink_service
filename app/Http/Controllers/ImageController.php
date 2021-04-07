<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Http\Services\Archivator\Interfaces\IArchivatorInterface;
use App\Http\Services\Archivator\RarArchivator;
use App\Http\Services\Archivator\ZipArchivator;
use App\Http\Services\RequestResolver;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Storage;
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
        $response = new Response($result->getPathName());
        $response
            ->header('Content-Type', 'application/zip')
            ->header('Content-Disposition', 'attachment; filename=' . $result->getFileName() . '.zip');
        \File::delete($result->getPathName());
        return $response;
    }
}
