@extends('layouts.app')

@section('title', '| Edit Info')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <img class="img-thumbnail"src="{{asset('images/'.$member->image)}}">
            <br><br>
        </div>
        <div class="col-md-6">
            <h3>Edit {{$member->name}}'s Info</h3>
            <hr>
            
            <form action="{{route('member.update', $member->id)}}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                
                
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-left">Name*</label>
                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="name" value="{{$member->name}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="designation" class="col-md-4 col-form-label text-md-left">Designation*</label>
                    <div class="col-md-8">
                        <select class="form-control" name="designation">
                            <option value="General Member" {{$member->designation=='General Member'?'selected':''}}>General Member</option>
                            <option value="Founder" {{$member->designation=='Founder'?'selected':''}}>Founder</option>
                            <option value="President" {{$member->designation=='President'?'selected':''}}>President</option>
                            <option value="Local" {{$member->designation=='Local'?'selected':''}}>Local</option>
                            <option value="Vice President" {{$member->designation=='Vice President'?'selected':''}}>Vice President</option>
                            <option value="Secretary" {{$member->designation=='Secretary'?'selected':''}}>Secretary</option>
                            <option value="Tresurer" {{$member->designation=='Tresurer'?'selected':''}}>Tresurer</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="image" class="col-md-4 col-form-label text-md-left">Update Image(LIM: 2 MB)</label>
                    <div class="col-md-8">
                        <input type="file" class="form-control-file" id="image" name="image" accept="image/*"`>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="joined_on" class="col-md-4 col-form-label text-md-left">Joined On</label>
                    <div class="col-md-8">
                        <input id="joined_on" type="date" class="form-control" name="joined_on" value="{{$member->date_of_birth}}">
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="contact_number" class="col-md-4 col-form-label text-md-left">Contact Number</label>
                    <div class="col-md-8">
                        <input id="contact_number" type="text" class="form-control" name="contact_number" value="{{$member->contact_number}}">
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="address" class="col-md-4 col-form-label text-md-left">Address</label>
                    <div class="col-md-8">
                        <input id="address" type="text" class="form-control" name="address" value="{{$member->address}}">
                    </div>
                </div>

                <input type="submit" class= "btn btn-success btn-block" value="Save Changes">

            </form>
            <br>
            <a href="{{route('member.show', $member)}}" class= "btn btn-danger btn-block">Cancel</a>
        </div>
    </div>
@endsection