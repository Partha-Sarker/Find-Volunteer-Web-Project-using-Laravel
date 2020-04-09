@extends('layouts.app')
@section('title', '| Profile')
@section('content')
    <div class="row">
        <div class="col-md-3">
            <a href="{{asset('images/'.$organization->User->photo)}}"><img class="img-thumbnail" src="{{asset('images/'.$organization->User->photo)}}"></a>
            <br><br>
        </div>
        <div class="col-md-6">
            <h3>{{$organization->name}}</h3>
            <hr>
            <table class="table table-borderless table-sm">
                <tr>
                    <td>Name</td>
                    <td>{{$organization->name}}</td>
                </tr>
                <tr>
                    <td>Type</td>
                    <td class="text-capitalize">{{$organization->type}}</td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td class="text-capitalize">{{$organization->description}}</td>
                </tr>
                <tr>
                    <td>Founded On</td>
                    <td class="text-capitalize">{{date('d M Y', strtotime($organization->founded_on))}}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{$organization->User->email}}</td>
                </tr>
            </table>
            @auth
                @if (Auth::user()->id == $organization->user_id)
                    <a href="{{route('organization.edit', $organization->id)}}" class= "btn btn-info btn-block">Edit Profile</a>
                @endif
            @endauth
        </div>
        <div class="col-md-3">
            @include('partials._my_events')
            <hr>
            @include('partials._my_members')
        </div>
    </div>
@endsection