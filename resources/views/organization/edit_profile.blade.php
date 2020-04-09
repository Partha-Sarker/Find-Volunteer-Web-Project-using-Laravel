@extends('layouts.app')

@section('title', '| Edit Profile')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <img class="img-thumbnail" src="{{asset('images/'.$organization->User->photo)}}">
            <br><br>
        </div>
        <div class="col-md-6">
            <h3>My Information</h3>
            <hr>
            
            <form action="{{route('organization.update', $organization->id)}}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                
                
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-left">Name*</label>
                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="name" value="{{$organization->name}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="photo" class="col-md-4 col-form-label text-md-left">Update Photo(LIM: 2 MB)</label>
                    <div class="col-md-8">
                        <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*"`>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="type" class="col-md-4 col-form-label text-md-left">Type*</label>
                    <div class="col-md-8">
                        <select class="form-control" name="type">
                            <option value="music" {{$organization->gender=='music'?'selected':''}}>Music</option>
                            <option value="education" {{$organization->gender=='education'?'selected':''}}>Education</option>
                            <option value="entertainment" {{$organization->gender=='entertainment'?'selected':''}}>Entertainment</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label text-md-left">Description</label>
                    <div class="col-md-8">
                        <textarea id="description" type="textarea" class="form-control" name="description" rows="4" value=>{{$organization->description}}</textarea>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="founded_on" class="col-md-4 col-form-label text-md-left">Founded On*</label>
                    <div class="col-md-8">
                        <input id="founded_on" type="date" class="form-control" name="founded_on" value="{{$organization->founded_on}}">
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="facebook" class="col-md-4 col-form-label text-md-left">Facebook</label>
                    <div class="col-md-8">
                        <input id="facebook" type="text" class="form-control" name="facebook" value="{{$organization->facebook}}">
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="twitter" class="col-md-4 col-form-label text-md-left">Twitter</label>
                    <div class="col-md-8">
                        <input id="twitter" type="text" class="form-control" name="twitter" value="{{$organization->twitter}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="youtube" class="col-md-4 col-form-label text-md-left">Youtube</label>
                    <div class="col-md-8">
                        <input id="youtube" type="text" class="form-control" name="youtube" value="{{$organization->youtube}}">
                    </div>
                </div>

                <input type="submit" class= "btn btn-success btn-block" value="Save Changes">

            </form>
            <br>
            <a href="{{route('organization.show', $organization->id)}}" class= "btn btn-danger btn-block">Cancel</a>
        </div>
    </div>
@endsection