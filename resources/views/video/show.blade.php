@extends('layouts.app')
@push('css')
    <style>
        .video-placeholder{
            position: relative;
            background-color: #111;
            padding-top: 56.25%;
            width: 100%;
            max-width: 100%;
        }
        .video-placeholder_header
        {
            position: absolute;
            top: 50%;
            left: 50%;
            font-size: 14px;
            transform: translateX(-50%)
        }
    </style>
@endpush



@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card-header">
                    @if($video->isPrivate() && Auth::check() && $video->ownedByUser(Auth::user()))
                        <div class="alert alert-info">
                            your video is currently private.only you can see it.
                        </div>
                    @endif
                    @if($video->canBeAccessed(Auth::user()))
                        show video player
                    @endif

                    @if(! $video->canBeAccessed(Auth::user()))
                        <div class="video-placeholder">
                            <div class="video-placeholder_header">
                                this video is private
                            </div>
                        </div>
                    @endif
                </div>
               

           
                
                    <div class="card card-body">
                       <h4>{{$video->title}}</h4>
                       <div class="float-end">
                            video views
                       </div>
                       <div class="media">
                            <div class="media-left">
                                <a href="/channel/{{$video->channel->slug}}">
                                    <img src="{{$video->channel->getImage()}}" class="mr-3" alt="Image">

                                </a>
                            </div>
                            <div class="media-body">
                            <h5 class="mt-0">Media Heading</h5>
                            <p>This is some sample text to describe the media object.</p>
                            </div>
                      </div>
                    </div>
                    @if ($video->description)
                    <div class="card card-body">
                        {!! nl2br($video->description) !!}
                     </div>
                    @endif
                   
            
            </div>
        </div>
    </div>
@endsection
