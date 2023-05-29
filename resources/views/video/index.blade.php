@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Videos</div>

                <div class="card-body">
                    @if ($videos->count())
                        @foreach ($videos as $video)
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-sm-5">
                                       
                                            <video width="320" height="240" controls>
                                            <source src="{{asset('videos/' .$video->video_filename)}}" type="video/mp4">
                                            <source src="movie.ogg" type="video/ogg">
                                            Your browser does not support the video tag.
                                            </video>
                                     
                                    </div>
                                    <div class="col-sm-7">
                                        <a href="/videos/{{$video->uid}}">{{$video->title}}</a>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                {{$video->created_at->toDateTimeString()}}
                                                <form action="/videos/{{$video->uid}}" method="post">
                                                    @csrf
                                                    {{method_field('DELETE')}}
                                                    <a href="/videos/{{$video->uid}}/edit" class="btn btn-info">Edit</a>
                                                    <button type="submit" class="btn btn-danger">delete</button>
                                                </form>    
                                            </div>
                                            <div class="col-sm-6">
                                                {{ucfirst($video->visiblity)}}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>        
                            
                        @endforeach
                        {!! $videos->links() !!}
                    @else
                        <p>No Videos Founded</p>    
                    @endif

                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
