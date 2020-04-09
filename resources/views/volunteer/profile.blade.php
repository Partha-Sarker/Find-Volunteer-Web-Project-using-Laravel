@extends('layouts.app')
@section('title', '| Profile')
@section('content')
    <div class="row">
        {{-- left section --}}
        <div class="col-md-3">
            <a href="{{asset('images/'.$volunteer->User->photo)}}"><img class="img-thumbnail rounded" src="{{asset('images/'.$volunteer->User->photo)}}"></a>
            <hr>
            @auth
                <p class="text-center"><strong>Circulars</strong></p>
                <hr>
                @include('partials._my_circulars')
            @endauth
        </div>

        {{-- middle section --}}
        <div class="col-md-6">
            <h3>About {{$volunteer->first_name}}</h3>
            <hr>
            <table class="table table-borderless table-sm">
                <tr>
                    <td>First Name</td>
                    <td>{{$volunteer->first_name}}</td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td>{{$volunteer->last_name}}</td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td class="text-capitalize">{{$volunteer->gender}}</td>
                </tr>
                <tr>
                    <td>Date Of Birth</td>
                    <td class="text-capitalize">{{date('d M Y', strtotime($volunteer->date_of_birth))}}</td>
                </tr>
                <tr>
                    <td>Contact Number</td>
                    <td>{{$volunteer->contact_number}}</td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td>{{$volunteer->address}}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{$volunteer->User->email}}</td>
                </tr>
                <tr>
                    <td>Profession</td>
                    <td class="text-capitalize">{{$volunteer->profession}}</td>
                </tr>
                <tr>
                    <td>Department</td>
                    <td>{{$volunteer->department}}</td>
                </tr>
                @if ($volunteer->Proffession=='student')
                    <tr>
                        <td>Registration Number</td>
                        <td>{{$volunteer->reg_no}}</td>
                    </tr>
                @endif
            </table>
            @auth
                @if (Auth::user()->id == $volunteer->user_id)
                    <a href="{{route('volunteer.edit', $volunteer->id)}}" class= "btn btn-info btn-block">Edit Profile</a>
                @endif
            @endauth
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            Rating
                        </div>
                        <div class="col-md-5">
                            {{$volunteer->rating}}
                        </div>
                        <div class="col-md-7">
                            Events Participation
                        </div>
                        <div class="col-md-5">
                            {{count($events)}}
                        </div>
                    </div>
                        @auth
                        @if (Auth::user()->role=='organization')
                            @php
                                $data = App\OrganizationVolunteer::where(['volunteer_id' => $volunteer->id, 'organization_id' => Auth::user()->Organization->id])->first();
                                $rating=0;
                                if($data!=null){
                                    $rating = $data['rating'];
                                }
                            @endphp
                            <form  action="{{route('organization.rate',$volunteer->id)}}" method="POST">
                                @csrf
                                <div class="form-row">
                                    <div class="col-5">
                                        <select class="form-control" name="rating">
                                            <option value="0" {{$rating==0?'selected':''}}>0</option>
                                            <option value="1" {{$rating==1?'selected':''}}>1</option>
                                            <option value="2" {{$rating==2?'selected':''}}>2</option>
                                            <option value="3" {{$rating==3?'selected':''}}>3</option>
                                            <option value="4" {{$rating==4?'selected':''}}>4</option>
                                            <option value="5" {{$rating==5?'selected':''}}>5</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary btn-sm m-1">rate</button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
            <hr>
            <p class="text-center"><strong>{{Auth::user()!=null && Auth::user()->role=='volunteer' && Auth::user()->Volunteer->id == $volunteer->id ? "My Participations":"Participated In"}}</strong></p>
            <hr>
            @if (count($events)>0)
                <div class="list-group">
                    @foreach ($events as $event)
                        <a class="list-group-item list-group-item-action py-2" href="{{route('event.show', $event->id)}}">{{$event->name}}</a>
                    @endforeach      
                </div>
            @else
                <p class="text-center">No Event</p>
            @endif
        </div>
    </div>
@endsection