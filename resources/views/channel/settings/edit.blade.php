@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Channel Settings</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('/channel/' . $channel->slug .'/edit') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">


                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name')??$channel->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Slug" class="col-md-4 col-form-label text-md-end">Unique Url</label>

                            <div class="col-md-6  mb-3">
                                <span class="input-group-text" id="basic-addon3">{{config('app.url')}}/channel </span>
                                <input id="basic-url" type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug')??$channel->slug }}" aria-describedby="basic-addon3" required autocomplete="slug" autofocus>

                                @error('slug')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                    </div>

                    <div class="row form-group mb-3">
                        <label for="description" class="col-md-4 col-form-label text-md-end">Description</label>

                        <div class="col-md-6">
                            <textarea  cols="30" rows="10" class="form-control @error('description') is-invalid @enderror" name="description" >
                                {{ old('description') ?? $channel->description}}
                            </textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group mb-3">
                        <label for="channel_image" class="col-md-4 col-form-label text-md-end">channel image</label>

                        <div class="col-md-6">
                            <input type="file" id="image"  class="form-control @error('image') is-invalid @enderror" name="image" />
                            @if ($channel->image_filename)
                                <img src="{{$channel->image_filename}}" width="100" height="100" />
                            @endif
      
                        </div>
                    </div>


                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    save
                                </button>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
