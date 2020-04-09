{{-- need all events organized by a organization --}}

<p class="text-center">
    <strong>{{Auth::user()!=null && Auth::user()->role=='organization' && Auth::user()->Organization->id == $organization->id ? "My Events":"Organized Events"}}</strong>
</p>
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
<br>
<a href="{{route('organization.events',$organization->id)}}" class= "btn btn-secondary btn-block">View All</a>
@auth
    @if (Auth::user()->id == $organization->user_id)
        <a href="{{route('event.create')}}" class= "btn btn-success btn-block">Create New Event</a>
    @endif
@endauth