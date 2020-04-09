@extends('layouts.app')
@section('title', '| Edit Comment')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <img class="w-100" src="{{asset('images/'.$circular->image)}}">
        </div>
        <div class="col-md-6">
            <span class="h3">Edit Comment</span>
            <span class="h3 float-right">Circular: <strong>{{$circular->name}}</strong></span>
            <hr>
            <form action="{{route('comment.update', [$circular->id, $comment])}}" method="POST">
                @method('PUT')
                @csrf
                <div class="form-group row">
                    <label for="comment" class="col-md-4 col-form-label text-md-left">Comment*</label>
                    <div class="col-md-8">
                        <textarea id="comment" type="textarea" class="form-control" name="comment" rows="4" value=>{{$comment->comment}}</textarea>
                    </div>
                </div>
                <input type="submit" class= "btn btn-success btn-block" value="Update Comment">
            </form>
        </div>
    </div>
@endsection