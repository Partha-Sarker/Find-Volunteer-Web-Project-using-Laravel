{{-- need all volunteers sorted by rating --}}

<strong>Top Volunteer</strong>
<hr>
@if (count($volunteers)>0)
    <div class="list-group">
        @foreach ($volunteers as $volunteer)
            <a class="list-group-item list-group-item-action py-2" href="{{route('volunteer.show', $volunteer->id)}}">{{$volunteer->first_name.' '.$volunteer->last_name}}</a>
        @endforeach
    </div>
@else
    <p class="text-center">No volunteer</p>
@endif
<br>
<a href="{{route('volunteer.index')}}" class= "btn btn-secondary btn-block">View All</a>