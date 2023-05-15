<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChannelUpdateRequest;
use App\Jobs\UploadImage;
use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelSettingsController extends Controller
{
    public function edit(Channel $channel)
    {
        $this->authorize('edit',$channel);
        return view('channel.settings.edit',[
            'channel'=> $channel
        ]);

        # code...
    }
    public function update(Channel $channel,ChannelUpdateRequest $request)
    {
        $this->authorize('update',$channel);

        $channel->update($request->validated());
        if($request->file('image'))
        {
            $request->file('image')->move(storage_path() . '/uploads',$file_id=uniqid(true));
            // $this->dispatch(new UploadImage($channel,$file_id));
            UploadImage::dispatch($channel,$file_id);
        }

        return redirect()->to('/channel/' . $channel->slug . '/edit');

    }
}
