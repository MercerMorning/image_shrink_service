<?php

namespace App\Http\Services;

use App\Http\Requests\ImageRequest;
use App\Http\Services\Archivator\Interfaces\IArchivatorInterface;
use App\Http\Services\Archivator\RarArchivator;
use App\Http\Services\Archivator\ZipArchivator;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Pipeline\Pipeline;
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
                $archive = match ($request->input('archiveType')) {
                    'zip' => new ZipArchivator($file),
                    default => throw new \Exception('Unexpected match value')
                };
                $archive->createArchive();
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
