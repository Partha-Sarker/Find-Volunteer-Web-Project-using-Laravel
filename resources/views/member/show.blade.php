@extends('layouts.app')
@section('title', '| Profile')
@section('content')
    <div class="row">
        <div class="col-md-3">
            <a href="{{asset('images/'.$member->image)}}"><img class="img-thumbnail"src="{{asset('images/'.$member->image)}}"></a>
            <br><br>
            <br><br>
        </div>
        <div class="col-md-6">
            <h3>{{$member->name}}<strong> in </strong><a href="{{route('organization.show', $organization->id)}}">{{$organization->name}}</a></h3>
            <hr>
            <table class="table table-borderless table-sm">
                <tr>
                    <td>Name</td>
                    <td>{{$member->name}}</td>
                </tr>
                <tr>
                    <td>Designation</td>
                    <td>{{$member->designation}}</td>
                </tr>
                <tr>
                    <td>Joined On</td>
                    <td>{{date('d M Y', strtotime($member->joined_on))}}</td>
                </tr>
                <tr>
                    <td>Number</td>
                    <td>{{$member->contact_number}}</td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td>{{$member->address}}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{$member->email}}</td>
                </tr>
            </table>
            @auth
                @if (Auth::user()->id == $organization->user_id)
                    <a href="{{route('member.edit', $member->id)}}" class= "btn btn-info btn-block">Edit Info</a>
                    <form action="{{route('member.destroy', $member)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-block mt-2">Remove Member</button>
                    </form>
                @endif
            @endauth
        </div>
        <div class="col-md-3">
            {{-- @auth
                @if (Auth::user()->role == 'organization')
                    @include('partials._my_members')
                @endif
            @endauth --}}
        </div>
    </div>
@endsection