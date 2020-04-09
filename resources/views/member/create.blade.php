@extends('layouts.app')

@section('title', '| Add Member')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <hr>
        </div>
        <div class="col-md-6">
            <h3>Add New Member</h3>
            <hr>
            
            <form action="{{route('member.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-left">Name*</label>
                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="name">
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="designation" class="col-md-4 col-form-label text-md-left">Designation*</label>
                    <div class="col-md-8">
                        <select class="form-control" name="designation">
                            <option value="General Member">General Member</option>
                            <option value="Founder">Founder</option>
                            <option value="President">President</option>
                            <option value="Local">Local</option>
                            <option value="Vice President">Vice President</option>
                            <option value="Secretary">Secretary</option>
                            <option value="Tresurer">Tresurer</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="image" class="col-md-4 col-form-label text-md-left">Image(LIM: 2 MB)</label>
                    <div class="col-md-8">
                        <input type="file" class="form-control-file" id="image" name="image" accept="image/*"`>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="joined_on" class="col-md-4 col-form-label text-md-left">Joined On</label>
                    <div class="col-md-8">
                        <input id="joined_on" type="date" class="form-control" name="joined_on">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="contact_number" class="col-md-4 col-form-label text-md-left">Contact Number</label>
                    <div class="col-md-8">
                        <input id="contact_number" type="text" class="form-control" name="contact_number">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-left">Email</label>
                    <div class="col-md-8">
                        <input id="email" type="email" class="form-control" name="email">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="address" class="col-md-4 col-form-label text-md-left">Address</label>
                    <div class="col-md-8">
                        <input id="address" type="text" class="form-control" name="address">
                    </div>
                </div>

                <input type="submit" class= "btn btn-success btn-block" value="Add New Member">

            </form>
            <br>
            <a href="{{route('organization.index')}}" class= "btn btn-danger btn-block">Cancel</a>
        </div>
    </div>
@endsection