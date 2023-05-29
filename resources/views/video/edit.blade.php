@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Video "{{$video->title}}"</div>

                <div class="card-body">

                   <form action="/videos/{{$video->uid}}" method="post">
                        @csrf
                        {{ method_field('PUT') }}
                         <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" id="title" class="form-control" value="{{ old('title')?? $video->title}}" name="title">
                                    @error('title')
                                        <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea cols="10" rows="8" id="description" class="form-control">
                                    {{ old('description')??$video->description}}
                                </textarea>
                                   @error('description')
                                        <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                            </div>
                             <div class="form-group">
                                <label for="visibilty">visibilty</label>
                                <select name="visiblity" id="visibilty" class="form-control">
                                    @foreach (['private','unlisted','public'] as $visibilty)
                                          <option value="{{$visibilty}}" {{$video->visibilty == $visibilty ?'checked':''}}> {{ucfirst($visibilty)}}</option>
                                    @endforeach

                                </select>
                                 @error('visiblity')
                                    <div class="alert alert-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="Allow_votes">
                                    <input type="checkbox"  name="allow_votes" {{$video->votesAllowed() ? 'checked':''}}>Allow Votes
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="Allow_comments">
                                    <input type="checkbox"  name="allow_comments" {{$video->commentsAllowed() ? 'checked':''}}>Allow Comments
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary">update</button>
                   </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
