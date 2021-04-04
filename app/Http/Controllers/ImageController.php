<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArchiveTypeRequest;
use App\Http\Requests\ImageRequest;
use App\Http\Services\ImageShrink;
use App\Http\Services\Interfaces\IArchivatorInterface;
use App\Http\Services\RarArchivator;
use App\Http\Services\ZipArchivator;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Str;
use Spatie\ImageOptimizer\OptimizerChain;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Symfony\Component\HttpFoundation\File\File;

class ImageController extends Controller
{
    private $file;

    function __construct(ImageRequest $file)
    {
        $this->file = $file->file('image');
    }

    function shrink(Request $request)
    {
       $queue = new Pipeline();
       $queue
           ->send($this->file)
           ->through([
               function ($file, $next) {
                   $file = $file->move(public_path('compress'),
                       \Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) .  Str::uuid() .'.' . $file->getClientOriginalExtension());
                   return $next($file);
               },
               function ($file, $next) {
                   $optimizerChain = OptimizerChainFactory::create();
                   $optimizerChain->optimize($file->getPathname());
                   return $next($file);
               },
               function ($file, $next) use ($request){
                   $archive = match ($request->input('archiveType')) {
                       'zip' => new ZipArchivator($file),
                       default => throw new \Exception('Unexpected match value')
                   };
                   $archive->createArchive();
                   if (!$archive instanceof IArchivatorInterface) throw new \Exception('Archivator doesnt implement correct contract');
                   return  $archive;
               }
           ]);
       $file = $queue->thenReturn();
       return response()->download($file->getPathName());
    }
}
