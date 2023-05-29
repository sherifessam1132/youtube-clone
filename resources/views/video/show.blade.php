@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card-header">Video Player</div>
               

           
                
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
