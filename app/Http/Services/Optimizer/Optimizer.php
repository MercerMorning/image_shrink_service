<?php
namespace App\Http\Services\Optimizer;

use Spatie\ImageOptimizer\Optimizers\Pngquant;
use Symfony\Component\HttpFoundation\File\File;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class Optimizer
{
    private $optimizerChain;
    private $filePath;
//    private $allowedOptimizers =  ['Pngquant'];

    private function allowedOptimizers()
    {
        yield new Pngquant();
    }

    public function __construct(File $file)
    {
//        $optimizerType = collect($optimizerType)->intersect($this->allowedOptimizers)->values()->toArray();
//        dd($optimizerType);
        $this->optimizerChain = OptimizerChainFactory::create();
        $this->filePath = $file->getPathname();
    }

    public function optimize() : void
    {
//        foreach ($this->allowedOptimizers() as $optimizer) {
//            $this->optimizerChain->addOptimizer($optimizer)->optimize($this->filePath);
//        }
        $this->optimizerChain->optimize($this->filePath);
    }


}
