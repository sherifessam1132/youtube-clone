<?php

namespace App\Http\Controllers;

use App\Jobs\UploadVideo;
use Illuminate\Http\Request;

class VideoUploadController extends Controller
{
    public function index()
    {
        return view('video.upload');
    }
    public function store(Request $request)
    {
        ini_set('memory_limit','10240M');

        $channel=$request->user()->channel()->first();
        $video=$channel->videos()->where('uid',$request->uid)->firstOrFail();
        $request->file('video')->move(storage_path() . '/videos',$video->video_filename);

        $this->dispatch(new UploadVideo($video->video_filename));
    }
}
