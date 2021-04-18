<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\File;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DeletingFiles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $path;
    protected $seconds;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
//       $this->seconds = $seconds;
//        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo 123;
//        sleep($this->seconds);
//        \File::delete($this->path);
    }
}

