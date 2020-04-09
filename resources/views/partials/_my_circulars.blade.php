{{-- needs a $volunteer --}}

@php
    $myCirculars =  DB::table('volunteers')->join('circular_volunteer', 'volunteers.id', '=', 'circular_volunteer.volunteer_id')
                ->join('circulars', 'circulars.id', '=', 'circular_volunteer.circular_id')
                ->select('circulars.id', 'circulars.name', 'circulars.event_id', 'circular_volunteer.status')
                ->where('volunteers.id', $volunteer->id)->orderBy('circular_volunteer.status')->get();
@endphp

@if (count($myCirculars)>0)
    <div class="list-group">
        @foreach ($myCirculars as $circular)
            <a class="list-group-item list-group-item-action py-2" href="{{route('circular.show', [$circular->event_id, $circular->id])}}">{{$circular->name}}
                @if ($circular->status == 'pending')
                    <span class="badge badge-primary badge-pill float-right">pending</span>
                @endif
                @if ($circular->status == 'accepted')
                    <span class="badge badge-success badge-pill float-right">accepted</span>
                @endif
                @if ($circular->status == 'rejected')
                    <span class="badge badge-danger badge-pill float-right">rejected</span>
                @endif
            </a>
        @endforeach
    </div>
@else 
    No Circular
@endif