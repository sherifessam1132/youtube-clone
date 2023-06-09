<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class EncodingWebhookController extends Controller
{
    public function handle(Request $request)
    {
       $event=camel_case($request->event);  
    
       if(method_exists($this,$event))
       {
        $this->{$event}($request);
       }
    }
    protected function videoEnconded(Request $request)
    {
        $video=$this->getVideoByFilename($request->original_filename);
        $video->processed =true;
        $video->video_id = $request->encoding_ids[0];
        $video->save();
        # code...
    }
    protected function encodedProgress(Request $request)
    {
        $video=$this->getVideoByFilename($request->original_filename);
        $video->processed_percentage = $request->progress;
        $video->save();
    }

    protected function getVideoByFilename($filename)
    {
       return Video::where('video_filename',$filename)->firstOrFail();

    }

}
