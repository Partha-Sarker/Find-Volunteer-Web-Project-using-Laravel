@extends('layouts.app')
@section('title',"| Events by $organization->name")
@section('content')
    <h2 class="text-center">Events Organized by <a style="text-decoration:none" href="{{route('organization.show', $organization)}}">{{$organization->name}}</a></h2>
    <div class="row">
        <div class="col-md-3">
            @auth
                @if (Auth::user()->role=='organization')
                    {{-- @if (Auth::user()->Organization->id != $organization->id)
                        @include('partials._my_events')
                    @endif --}}
                    <a href="{{route('event.create')}}" class= "btn btn-success btn-block">Create New Event</a>
                    <hr>
                    @include('partials._top_volunteers')
                @else
                    @include('partials._top_volunteers')
                @endif
            @endauth
        </div>
        <div class="col-md-6">
            <hr>
            @if (count($events)>0)
                @foreach ($events as $event)
                    <div class="card mb-2">
                        <div class="card-header">
                            <a href="{{route('event.show', $event)}}" class="btn btn-light btn-lg py-0 px-0">{{$event->name}}</a>
                            <strong>Organized by</strong>
                            <a href="{{route('organization.show', $event->Organization)}}" class="btn btn-light btn-lg py-0 px-0">{{$event->Organization->name}}</a>
                            <span class="float-right px-1 text-white bg-primary border rounded">circulars: {{count($event->Circular)}}</span>
                        </div>
                        <div class="card-body">
                            <span class="h6 card-subtitle mb-2 text-muted">Created At: {{$event->created_at}}</span>
                            @if ($event->start_time!=null)
                                <span class="h6 card-subtitle m-0 p-0 text-white bg-dark border rounded">Started On: {{$event->start_time}}</span>
                            @endif
                            @if ($event->status=='Ended')
                                <span class="h6 card-subtitle m-0 p-0 text-white bg-dark border rounded">Ended On: {{$event->end_time}}</span>
                            @else
                                <span class="h6 card-subtitle m-0 p-0 text-white bg-dark border rounded">{{$event->status}}</span>
                            @endif
                            @if ($event->default_image!='no_image.png')
                                <div>
                                    <img src="{{asset('images/'.$event->default_image)}}" alt="">
                                </div>
                            @endif
                            <p class="h5 card-text mt-2">{{$event->description}}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <h2 class="text-center">No event</h2>
            @endif
            <br>
            <ul class="pagination justify-content-center">{{ $events->links() }}</ul>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <h5><strong>Number Of Events:</strong></h5>
                        </div>
                        <div class="col-md-3">
                            <h5>{{count($events)}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection