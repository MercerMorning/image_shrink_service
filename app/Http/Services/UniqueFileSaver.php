<?php
namespace App\Http\Services;

use App\Helpers\UniqueName;
use Illuminate\Http\UploadedFile;
use Spatie\ImageOptimizer\Optimizers\Pngquant;
use Symfony\Component\HttpFoundation\File\File;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class UniqueFileSaver
{
//    public function __construct(File $file)
//    {
////        $optimizerType = collect($optimizerType)->intersect($this->allowedOptimizers)->values()->toArray();
////        dd($optimizerType);
//        $this->optimizerChain = OptimizerChainFactory::create();
//        $this->filePath = $file->getPathname();
//    }

    public static function save(UploadedFile $file, string $prefix = null, string $path = null)
    {
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileExt = $file->getClientOriginalExtension();
        $fileUniqueName = UniqueName::generate($fileName, $fileExt, function ($name) use ($prefix){
            return ($prefix ?? '') . $name;
        });
        $renamedFile = $file->move($path, $fileUniqueName);
        return $renamedFile;
    }
}
