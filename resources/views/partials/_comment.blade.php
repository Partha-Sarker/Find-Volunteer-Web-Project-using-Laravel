<div class="my-2 px-2 bg-white rounded">
    <form class="" action="{{route('comment.destroy', [$circular->id, $comment])}}" method="POST">
        @csrf
        @method('DELETE')
        @if ($comment->User->role == 'volunteer')
            <a style="text-decoration:none" href="{{route('volunteer.show',$comment->User->Volunteer->id)}}">{{$comment->User->Volunteer->first_name}} </a>
        @else
            <a style="text-decoration:none" href="{{route('volunteer.show',$comment->User->Organization->id)}}">{{$comment->User->Organization->name}} </a>
        @endif
            <span class="small text-muted">{{date('g:i A, d M Y', strtotime($comment->updated_at))}}</span>
        @auth
            @if ($comment->User->id == Auth::user()->id)
                <button type="submit" class="btn btn-danger btn-sm p-0 mx-1 float-right">Delete</button>
                {{-- <button class="btn btn-link mx-0 px-0" type="submit"><i class="fas fa-trash"></i></button> --}}
                <a href="{{route('comment.edit',[$circular->id, $comment])}}" class="btn btn-warning btn-sm p-0 m-0 float-right">Edit</a>
                {{-- <a href="{{route('comment.edit',[$circular->id, $comment])}}"><i class="far fa-edit"></i></a> --}}
            @elseif($circular->Event->Organization->user_id == Auth::user()->id)
                <button type="submit" class="btn btn-danger btn-sm p-0 m-0 float-right">Delete</button>
                {{-- <button class="btn btn-link mx-0 px-0" type="submit"><i class="fas fa-trash"></i></button> --}}
            @endif
        @endauth
        <p>
            @if (Request::route()->getName()!='circular.show' && strlen(strip_tags($comment->comment)) > 140)
                {{substr(strip_tags($comment->comment), 0, 140)}}
                <a style="text-decoration:none" href="{{route('circular.show', [$circular->Event->id, $circular])}}">...</a>
            @else
                {{($comment->comment)}}
            @endif
        </p>
        
    </form>
</div>