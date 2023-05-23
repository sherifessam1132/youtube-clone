@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Vidoe</div>

                <div class="card-body">
                
                    @if($videos->count())
                        @foreach ($videos as $video)
                            <div class="card-header row">
                                <div class="col-md-3">
                                    <a href="/videos/{{$video->uid}}">
                                        <img src="{{ $video->get}}" alt="">
                                    </a>
                                </div>
                                <div class="col-md-9">
                                    <a href="/videos/{{$video->uid}}">{{$video->title}}</a>
                                    <div class="row">
                                        <div class="col-md-6">
                                            @if
                                        </div>
                                        <div class="col-md-6">
                                            {{ ucfirst($video->visiblity)}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>Yout Have No Vidoes.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
