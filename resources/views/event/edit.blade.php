@extends('layouts.app')

@section('title',"| edit $event->name")

@section('content')
    <div class="row">
        <div class="col-md-3">
            <hr>
        </div>
        <div class="col-md-6">
            <h3>Edit <i>{{$event->name}}</i><strong> by </strong><a href="">{{$event->Organization->name}}</a></h3>
            <hr>
            
            <form action="{{route('event.update', $event->id)}}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-left">Name*</label>
                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="name" value="{{$event->name}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label text-md-left">Description*</label>
                    <div class="col-md-8">
                        <textarea id="description" type="textarea" class="form-control" name="description" rows="4" value=>{{$event->description}}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="default_image" class="col-md-4 col-form-label text-md-left">Update Image(LIM: 2 MB)</label>
                    <div class="col-md-8">
                        <input type="file" class="form-control-file" id="default_image" name="default_image" accept="image/*"`>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="type" class="col-md-4 col-form-label text-md-left">Type*</label>
                    <div class="col-md-8">
                        <select class="form-control" name="type">
                            <option value="Local" {{$event->type=='Local'?'selected':''}}>Local</option>
                            <option value="Virtual" {{$event->type=='Virtual'?'selected':''}}>Virtual</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="status" class="col-md-4 col-form-label text-md-left">Status*</label>
                    <div class="col-md-8">
                        <select class="form-control" name="status">
                            <option value="Pending" {{$event->status=='Pending'?'selected':''}}>Pending</option>
                            <option value="Running" {{$event->status=='Running'?'selected':''}}>Running</option>
                            <option value="Ended" {{$event->status=='Ended'?'selected':''}}>Ended</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="start_time" class="col-md-4 col-form-label text-md-left">Starting time</label>
                    <div class="col-md-8">
                        <input id="start_time" type="date" class="form-control" name="start_time" value="{{$event->start_time}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="end_time" class="col-md-4 col-form-label text-md-left">Ending time</label>
                    <div class="col-md-8">
                        <input id="end_time" type="date" class="form-control" name="end_time"  value="{{$event->end_time}}">
                    </div>
                </div>

                <input type="submit" class= "btn btn-success btn-block" value="Save Changes">

            </form>
            <br>
            <a href="{{route('event.show', $event->id)}}" class= "btn btn-danger btn-block">Cancel</a>
        </div>
    </div>
@endsection