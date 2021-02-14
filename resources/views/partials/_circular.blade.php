{{-- it needs a $circular variable --}}
@php
    $comments = $circular->Comment->sortByDesc('updated_at');
@endphp

<div class="card mb-2">
    <div class="card-body">
        <h4 class="card-title">
            <a href="{{route('circular.show', [$circular->Event->id, $circular])}}" style="text-decoration:none">{{$circular->name}}</a>
            <strong>under</strong> 
            <a href="{{route('event.show',$circular->Event->id)}}" style="text-decoration:none">
                {{$circular->Event->name}}
            </a>
            <strong>by</strong> 
            <a href="{{route('organization.show',$circular->Event->Organization->id)}}" style="text-decoration:none">
                {{$circular->Event->Organization->name}}
            </a>
            @auth
                @if ($circular->Event->Organization->user_id == Auth::user()->id)
                    <a href="{{route('circular.edit', [$circular->Event->id, $circular->id])}}" class="btn btn-danger btn-sm float-right">Edit</a>
                @endif
            @endauth
            @auth
                @if (Auth::user()->role=='volunteer')
                    @php
                        // $data = DB::table('circular_volunteer')->where('circular_id', 3)->where('volunteer_id', Auth::user()->Volunteer->id)->first();
                        $data = App\CircularVolunteer::where(['circular_id' => $circular->id,'volunteer_id' => Auth::user()->Volunteer->id])->first();
                        $status = "nothing";
                        if ($data != null)
                            $status=$data['status'];
                    @endphp
                    @if ($status=='pending')
                        <form action="{{route('volunteer.joinRequest', $circular)}}" method="POST">
                            @csrf
                            <input id="status" type="hidden" name="status" value="cancel request">
                            <input type="submit" class= "btn btn-warning btn-sm float-right" value="Cancel Join Request">
                        </form>
                    @elseif($status=='accepted')
                        <button type="button" class="btn btn-success btn-sm float-right mx-1" disabled>accepted</button>
                    @elseif($status=='rejected')
                        <button type="button" class="btn btn-danger btn-sm float-right mx-1" disabled>rejected</button>
                    @else
                        <form action="{{route('volunteer.joinRequest', $circular)}}" method="POST">
                            @csrf
                            <input id="status" type="hidden" name="status" value="pending">
                            <input type="submit" class= "btn btn-primary btn-sm float-right" value="Request Join">
                        </form>
                    @endif
                @endif
            @endauth
        </h4>
        <h6 class="card-subtitle mb-2 text-muted">{{date('g:ia d M Y', strtotime($circular->created_at))}}</h6>
        <hr>
        <p><span class="h4">{{' '.$circular->description}}</span></p>
        @if ($circular->image!='no_image.png')
            <a href="{{asset('images/'.$circular->image)}}"><img class="mb-2" src="{{asset('images/'.$circular->image)}}" width="400"></a>
        @endif
        <div class="p-2 bg-light">
            @auth
                <form action="{{route('comment.store', $circular->id)}}" method="POST" autocomplete="off">
                    @csrf
                    <input id="comment" type="text" class="form-control" name="comment" placeholder="comment">
                    <button type="submit" style="display: none;"></button>
                </form>
            @else
                <p class="text-center"><strong>comments</strong></p>
                <hr>
            @endauth
            @if(count($comments)>5)
                @php
                    $count = count($comments);
                @endphp
                @for ($i = $count-1; $i > $count-6; $i--)
                    @php
                        $comment = $comments[$i];
                    @endphp
                    @include('partials._comment')
                @endfor
                <a style="text-decoration:none" href="{{route('circular.show', [$circular->Event->id, $circular])}}"><p class="text-center m-0 p-0">view all comments</p></a>
            @elseif (count($comments)>0)
                @foreach ($comments as $comment)
                    @include('partials._comment')
                @endforeach
            @else 
                No comment
            @endif
        </div>
    </div>
</div>