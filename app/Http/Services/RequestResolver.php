<?php

namespace App\Http\Services;

use App\Helpers\UniqueName;
use App\Http\Requests\ImageRequest;
use App\Http\Services\Archivator\Archivator;
use App\Http\Services\Archivator\Interfaces\IArchivatorInterface;
use App\Http\Services\Archivator\RarArchivator;
use App\Http\Services\Archivator\ZipArchivator;
use App\Http\Services\Optimizer\Optimizer;
use Illuminate\Pipeline\Pipeline;
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
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $fileExt = $file->getClientOriginalExtension();
                $fileUniqueName = UniqueName::generate($fileName, $fileExt, function ($name) {
                    return 'optimized_' . $name;
                });
                $renamedFile = $file->move(public_path('compress'), $fileUniqueName);
                return $next($renamedFile);
            },
            function ($file, $next) use ($request) {
                $optimizer = new Optimizer($file, $request->only('optimizerType'));
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
