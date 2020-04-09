@extends('layouts.app')
@section('title',"| Volunteers")
@section('content')
    <div class="row">
        <div class="col-md-3">
            @auth
                @if (Auth::user()->role=='organization')
                    @include('partials._my_events')
                    <hr>
                    <strong>Top Volunteer</strong>
                    <hr>
                    @if (count($allVolunteers)>0)
                        <div class="list-group">
                            @foreach ($allVolunteers as $volunteer)
                                <a class="list-group-item list-group-item-action py-2" href="{{route('volunteer.show', $volunteer->id)}}">{{$volunteer->first_name.' '.$volunteer->last_name}}</a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center">No volunteer</p>
                    @endif
                    <br>
                    <a href="{{route('volunteer.index')}}" class= "btn btn-secondary btn-block">View All</a>
                @endif
            @endauth
        </div>
        <div class="col-md-6">
            <form autocomplete="off">
                <input id="search_item" type="text" class="form-control" name="search" placeholder="search volunteer">
                <button type="submit" style="display: none;" value="Search"></button>
            </form>
            @php
                $searchItem = Illuminate\Support\Facades\Input::get('search');
            @endphp
            @if ($searchItem != null && $searchItem != '')
                <div class="mt-3">
                    <span class="h4">search results for <strong>{{$searchItem}}</strong></span>
                </div>
            @endif
            <br>
            @if (count($volunteers)>0)
                @foreach ($volunteers as $volunteer)
                    @php
                        $events_count = DB::table('volunteers')->join('circular_volunteer', 'volunteers.id', '=', 'circular_volunteer.volunteer_id')
                        ->join('circulars', 'circulars.id', '=', 'circular_volunteer.circular_id')
                        ->join('events', 'events.id', '=', 'circulars.event_id')
                        ->select('events.*')->where('volunteers.id', $volunteer->id)->where('circular_volunteer.status','accepted')->distinct()->get()->count();
                    @endphp
                    <div class="card mb-2">
                        <div class="card-header">
                            <a href="{{route('volunteer.show', $volunteer)}}" class="btn btn-light btn-lg py-0 px-5">{{$volunteer->first_name.' '.$volunteer->last_name}}</a>
                            <span class="float-right px-1 text-white bg-primary border rounded">rating: {{$volunteer->rating}}</span>
                            <span class="float-right px-1 text-white bg-success border rounded">events: {{$events_count}}</span>
                        </div>
                    </div>
                @endforeach
            @else
                <h2 class="text-center">No volunteer</h2>
            @endif
            <br>
            <ul class="pagination justify-content-center">{{ $volunteers->links() }}</ul>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <h5><strong>Number Of Volunteers:</strong></h5>
                        </div>
                        <div class="col-md-3">
                            <h5>{{count($volunteers)}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection