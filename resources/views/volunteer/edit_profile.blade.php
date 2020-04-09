@extends('layouts.app')

@section('title', '| Edit Profile')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <img class="img-thumbnail" src="{{asset('images/'.$volunteer->User->photo)}}">
            <br><br>
        </div>
        <div class="col-md-6">
            <h3>Edit My Information</h3>
            <hr>
            
            <form action="{{route('volunteer.update', $volunteer->id)}}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                
                
                <div class="form-group row">
                    <label for="first_name" class="col-md-4 col-form-label text-md-left">First Name*</label>
                    <div class="col-md-8">
                        <input id="first_name" type="text" class="form-control" name="first_name" value="{{$volunteer->first_name}}">
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="last_name" class="col-md-4 col-form-label text-md-left">Last Name*</label>
                    <div class="col-md-8">
                        <input id="last_name" type="text" class="form-control" name="last_name" value="{{$volunteer->last_name}}">
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="gender" class="col-md-4 col-form-label text-md-left">Gender*</label>
                    <div class="col-md-8">
                        <select class="form-control" name="gender">
                            <option value="Male" {{$volunteer->gender=='Male'?'selected':''}}>Male</option>
                            <option value="Female" {{$volunteer->gender=='Female'?'selected':''}}>Female</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="date_of_birth" class="col-md-4 col-form-label text-md-left">Date Of Birth*</label>
                    <div class="col-md-8">
                        <input id="date_of_birth" type="date" class="form-control" name="date_of_birth" value="{{$volunteer->date_of_birth}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="photo" class="col-md-4 col-form-label text-md-left">Update Photo(LIM: 2 MB)</label>
                    <div class="col-md-8">
                        <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*"`>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="contact_number" class="col-md-4 col-form-label text-md-left">Contact Number*</label>
                    <div class="col-md-8">
                        <input id="contact_number" type="text" class="form-control" name="contact_number" value="{{$volunteer->contact_number}}">
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="address" class="col-md-4 col-form-label text-md-left">Address*</label>
                    <div class="col-md-8">
                        <input id="address" type="text" class="form-control" name="address" value="{{$volunteer->address}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="profession" class="col-md-4 col-form-label text-md-left">Profession*</label>
                    <div class="col-md-8">
                        <select class="form-control" name="profession">
                            <option value="Student" {{$volunteer->profession=='Student'?'selected':''}}>Student</option>
                            <option value="Employee" {{$volunteer->profession=='Employee'?'selected':''}}>Employee</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="department" class="col-md-4 col-form-label text-md-left">Department</label>
                    <div class="col-md-8">
                        <input id="department" type="text" class="form-control" name="department" value="{{$volunteer->department}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="reg_no" class="col-md-4 col-form-label text-md-left">Registration Number</label>
                    <div class="col-md-8">
                        <input id="reg_no" type="text" class="form-control" name="reg_no" value="{{$volunteer->reg_no}}">
                    </div>
                </div>

                <input type="submit" class= "btn btn-success btn-block" value="Save Changes">

            </form>
            <br>
            <a href="{{route('volunteer.show', $volunteer->id)}}" class= "btn btn-danger btn-block">Cancel</a>
        </div>
    </div>
@endsection