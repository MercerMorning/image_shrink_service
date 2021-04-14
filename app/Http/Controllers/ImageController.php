<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Http\Services\Archivator\Interfaces\IArchivatorInterface;
use App\Http\Services\Archivator\RarArchivator;
use App\Http\Services\Archivator\ZipArchivator;
use App\Http\Services\RequestResolver;
use Illuminate\Http\File;
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
        $this->middleware('auth:api', ['except' => ['login', 'registration']]);
        $this->file = $file->file('image');
    }

//    function optimize(ImageRequest $request)
    public function optimize(Request $request)
    {
        if ($request->ajax()) {
            $resolve = new RequestResolver();
            $result = $resolve->resolve($request);
            $file = new \Symfony\Component\HttpFoundation\File\File($result->getPathName());
//            $response = new Response($file->getContent());
//        $response = new Response(['content' => 123, 'name' =>  123]);
//            $response
//                ->header('Content-Type', $file->getType())
//                ->header('Content-Disposition', 'attachment; filename=' . $file->getFilename())
//                ->header('filename', $file->getFilename());
//            \File::delete($result->getPathName());

            return response()->make($result->getPathName());
        }
        return response()->json(['status' => 404]);
    }
}
