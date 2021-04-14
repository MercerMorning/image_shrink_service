<?php

namespace App\Http\Services;

use App\Helpers\UniqueName;
use App\Http\Requests\ImageRequest;
use App\Http\Services\Archivator\Archivator;
use App\Http\Services\Archivator\Interfaces\IArchivatorInterface;
use App\Http\Services\Optimizer\Optimizer;
use App\Http\Services\UniqueFileSaver;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Image;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Spatie\ImageOptimizer\Optimizers\Pngquant;

class RequestResolver
{
    private $pipeLine;

    public function __construct()
    {
        $this->pipeLine = new Pipeline();
    }

    public function resolve(Request $request)
    {
        $file = $request->file('image');
        $pipeActions = [
            function ($file, $next) {
                $renamedFile = UniqueFileSaver::save($file, 'optimized_', storage_path('app/compress'));
                return $next($renamedFile);
            },
//            $request->has('x', 'y', 'width', 'height') ? function ($file, $next) use ($request) {
//                $width = $request->input('width');
//                $height = $request->input('height');
//                $x = $request->input('x');
//                $y = $request->input('y');
//                $image = Image::load($file->getPathName());
//                $image->manualCrop($width, $height, $x, $y)->save();
//                return $next($file);
//            } : fn($file, $next) => $next($file),
//            $request->has('effect') ? function ($file, $next) use ($request) {
//                $image = Image::load($file->getPathName());
//                $image->blur(10);
//                $image->save();
//                return $next($file);
//            } : fn($file, $next) => $next($file),
            function ($file, $next) use ($request) {
                $optimizer = new Optimizer($file);
                $optimizer->optimize();
                return $next($file);
            },
            $request->has('archiveType') ? function ($file, $next) use ($request) {
                $archive = new Archivator($file, $request->input('archiveType'));
                $archive->createArchive();
                if (!$archive instanceof IArchivatorInterface) throw new \Exception('Archivator doesnt implement correct contract');
                return $next($archive);
            } : fn($file, $next) => $next($file)
        ];

        return $this->pipeLine
            ->send($file)
            ->through($pipeActions)
            ->thenReturn();
    }
}
