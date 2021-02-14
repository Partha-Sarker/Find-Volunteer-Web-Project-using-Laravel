@extends('layouts.app')

@section('title', '| Create Circular')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <hr>
        </div>
        <div class="col-md-6">
        <h3>Create New Circular <strong>under</strong> <a href="{{route('event.show',$event->id)}}">{{$event->name}}</a> event</h3>
            <hr>
            
            <form action="{{route('circular.store', $event->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-left">Name*</label>
                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="name">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label text-md-left">Description*</label>
                    <div class="col-md-8">
                        <textarea id="description" type="textarea" class="form-control" rows="4" name="description"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="image" class="col-md-4 col-form-label text-md-left">Add Image(LIM: 2 MB)</label>
                    <div class="col-md-8">
                        <input type="file" class="form-control-file" id="image" name="image" accept="image/*"`>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="status" class="col-md-4 col-form-label text-md-left">Status*</label>
                    <div class="col-md-8">
                        <select class="form-control" name="status">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <input type="submit" class= "btn btn-success btn-block" value="Create Circular">

            </form>
            <br>
            <a href="{{route('event.show', $event->id)}}" class= "btn btn-danger btn-block">Cancel</a>
        </div>
    </div>
@endsection