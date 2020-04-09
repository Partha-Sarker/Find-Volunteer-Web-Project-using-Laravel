@extends('layouts.app')

@section('title', '| Create Event')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <hr>
        </div>
        <div class="col-md-6">
            <h3>Create New Event</h3>
            <hr>
            
            <form action="{{route('event.store')}}" method="POST" enctype="multipart/form-data">
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
                    <label for="default_image" class="col-md-4 col-form-label text-md-left">Add Default Image(LIM: 2 MB)</label>
                    <div class="col-md-8">
                        <input type="file" class="form-control-file" id="default_image" name="default_image" accept="image/*"`>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="type" class="col-md-4 col-form-label text-md-left">Type*</label>
                    <div class="col-md-8">
                        <select class="form-control" name="type">
                            <option value="Local">Local</option>
                            <option value="Virtual">Virtual</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="status" class="col-md-4 col-form-label text-md-left">Status*</label>
                    <div class="col-md-8">
                        <select class="form-control" name="status">
                            <option value="Pending">Pending</option>
                            <option value="Running">Running</option>
                            <option value="Ended">Ended</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="start_time" class="col-md-4 col-form-label text-md-left">Starting time</label>
                    <div class="col-md-8">
                        <input id="start_time" type="date" class="form-control" name="start_time">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="end_time" class="col-md-4 col-form-label text-md-left">Ending time</label>
                    <div class="col-md-8">
                        <input id="end_time" type="date" class="form-control" name="end_time">
                    </div>
                </div>

                <input type="submit" class= "btn btn-success btn-block" value="Create New Event">

            </form>
            <br>
            <a href="{{route('organization.index')}}" class= "btn btn-danger btn-block">Cancel</a>
        </div>
    </div>
@endsection