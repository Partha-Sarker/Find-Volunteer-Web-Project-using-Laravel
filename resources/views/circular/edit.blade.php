@extends('layouts.app')

@section('title',"| edit $circular->name")

@section('content')
    <div class="row">
        <div class="col-md-3">
            <hr>
        </div>
        <div class="col-md-6">
            <h3>Edit <i>{{$circular->name}}</i> <strong>under</strong> <a href="{{route('event.show',$event->id)}}">{{$event->name}}</a></h3>
            <hr>
            
            <form action="{{route('circular.update', [$event->id, $circular])}}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-left">Name*</label>
                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="name" value="{{$circular->name}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label text-md-left">Description*</label>
                    <div class="col-md-8">
                        <textarea id="description" type="textarea" class="form-control" name="description" rows="4" value=>{{$circular->description}}</textarea>
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
                            <option value="Active" {{$circular->status=='Active'?'selected':''}}>Active</option>
                            <option value="Inactive" {{$circular->status=='Inactive'?'selected':''}}>Inactive</option>
                        </select>
                    </div>
                </div>

                <input type="submit" class= "btn btn-success btn-block" value="Save Changes">

            </form>
            <br>
            <a href="{{route('circular.show', [$event->id, $circular])}}" class= "btn btn-danger btn-block">Cancel</a>
        </div>
    </div>
@endsection