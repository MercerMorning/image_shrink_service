<?php

namespace App\Http\Services;

use App\Http\Requests\ImageRequest;
use App\Http\Services\Archivator\Archivator;
use App\Http\Services\Archivator\Interfaces\IArchivatorInterface;
use App\Http\Services\Archivator\RarArchivator;
use App\Http\Services\Archivator\ZipArchivator;
use App\Jobs\DeletingFiles;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Spatie\ImageOptimizer\Optimizers\Pngquant;

class RequestResolver
{
    private $pipeLine;

    public function __construct()
    {
        $this->pipeLine = new Pipeline();
    }

    public function resolve(ImageRequest $request)
    {
        $file = $request->file('image');
        $pipeActions = [
            function ($file, $next) {

//                $file = Storage::disk('local')->put('/', $file);
//                $file = Storage::disk('local')->put('/', $file);
//                $file = Storage::disk('local')->put('/', $file);
//                dd($file);
                $file = $file->move(public_path('compress'),
                    \Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) .  Str::uuid() .'.' . $file->getClientOriginalExtension());
                return $next($file);
            },
            function ($file, $next) {
                $optimizerChain = OptimizerChainFactory::create();
                $optimizerChain
                    ->addOptimizer(new Pngquant([
                        '--strip-all',
                        '--all-progressive',
                    ]))
                    ->optimize($file->getPathname());
                return $next($file);
            },
        ];
        if ($request->has('archiveType')) {
            $pipeActions[] = function ($file, $next) use ($request) {
                $archive = new Archivator($file, $request->input('archiveType'));
//                dispatch(new OptimizeProccess($archive));
                $archive->createArchive(10);
                if (!$archive instanceof IArchivatorInterface) throw new \Exception('Archivator doesnt implement correct contract');
                return  $archive;
            };
        }

        $result = $this->pipeLine
            ->send($file)
            ->through($pipeActions);
        return $result->thenReturn();
    }
}
