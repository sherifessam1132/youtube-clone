<?php

namespace App\Jobs;

use App\Models\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Image;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected Channel $channel,protected $fileId)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // dd('here');
        $path= storage_path() . '/uploads/' . $this->fileId;
        $fileName=$path .'.png';
        Image::make($path)->encode('png')->fit(40, 40, function ($constraint) {
            $constraint->upsize();
        })->save();
        $this->channel->image_filename=$fileName;
        $this->channel->save();
    }
}
