{{-- need $members of an organization --}}

<p class="text-center"><strong>Members</strong></p>
<hr>
@if (count($members)>0)
    <div class="list-group">
        @foreach ($members as $member)
            <a class="list-group-item list-group-item-action py-2" href="{{route('member.show', $member->id)}}">{{$member->name}}</a>
        @endforeach
    </div>
@else
    <p class="text-center">No Member</p>
@endif
<br>
@auth
    @if (Auth::user()->id == $organization->user_id)
        <a href="{{route('member.create')}}" class= "btn btn-info btn-block">Add new member</a>
    @endif
@endauth
<hr>