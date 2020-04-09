@extends('layouts.app')

@section('title',"| $circular->name")

@section('content')
    <div class="row">
        <div class="col-md-3">
            <a href="{{asset('images/'.$circular->image)}}"><img class="img-thumbnail mb-2" src="{{asset('images/'.$circular->image)}}"></a>
        </div>
        <div class="col-md-6">
            <div class="text-center">
                <h2>{{$circular->name}} <strong> under </strong><a style="text-decoration:none" href="{{route('event.show',$event->id)}}">{{$event->name}}</a>
                    <strong> by </strong><a style="text-decoration:none" href="{{route('organization.show', $event->Organization)}}">{{$event->Organization->name}}</a>
                </h2>
            </div>
            <hr>
            <h4><strong>Description: </strong>{{$circular->description}}</h4>
            <hr>
            <div class="card">
                <div class="card-header bg-white">Comments</div>
                <div class="card-body bg-light">
                    <form action="{{route('comment.store', $circular->id)}}" method="POST" autocomplete="off">
                        @csrf
                        <input id="comment" type="text" class="form-control" name="comment" placeholder="comment">
                        <button type="submit" style="display: none;"></button>
                    </form>
                    @if (count($comments)>0)
                        @foreach ($comments as $comment)
                            @include('partials._comment')
                        @endforeach
                    @else 
                        No comment
                    @endif
                    <ul class="pagination justify-content-center mt-4 mb-0 p-0">{{ $comments->links() }}</ul>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            Status
                        </div>
                        <div class="col-md-7">
                            {{$circular->status}}
                        </div>
                        <div class="col-md-5">
                            Circular Started
                        </div>
                        <div class="col-md-7">
                                {{date('d M Y  g:ia', strtotime($circular->created_at))}}
                        </div>
                        <div class="col-md-5">
                            Last Updated
                        </div>
                        <div class="col-md-7">
                                {{date('d M Y  g:ia', strtotime($circular->updated_at))}}
                        </div>
                    </div>
                    <br>
                    @auth
                        @if ($event->Organization->user_id == Auth::user()->id)
                            <form class="" action="{{route('circular.destroy', [$event->id, $circular])}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <a href="{{route('circular.edit',[$event->id, $circular])}}" class="btn btn-primary">Edit Circular</a>
                                <button type="submit" class="btn btn-danger float-right">Delete</button>
                            </form>
                        @endif
                    @endauth

                </div>
            </div>
            <p class="h2 text-center mt-3"><strong>Volunteers</strong></p>
            <hr>
            @foreach ($participants as $participant)
                @php
                    $data = App\CircularVolunteer::where(['circular_id' => $circular->id,'volunteer_id' => $participant->id])->first();
                    $status=$data['status'];
                @endphp
                <div class="row m-0 py-1">
                    <div class="col-md-6 p-0 m-0">
                        <a style="text-decoration:none" href="{{route('volunteer.show', $participant->id)}}">{{$participant->first_name.' '.$participant->last_name}}</a>
                    </div>
                    @if ($status=='accepted')
                        <div class="col-md-3 p-0 m-0">
                            <button type="button" class="btn btn-success btn-sm" disabled>accepted</button>
                        </div>
                    @elseif(Auth::user()!=null && Auth::user()->id == $circular->Event->Organization->user_id)
                        <div class="col-md-3 p-0 m-0">
                            <form action="{{route('circular.validateRequest', [$circular->Event->id, $circular->id, $participant->id])}}" method="POST">
                                @csrf
                                <input id="status" type="hidden" name="status" value="accepted">
                                <button type="submit" class="btn btn-success btn-sm">accept</button>
                            </form>
                        </div>
                    @endif
                    @if ($status=='rejected' && Auth::user()!=null && Auth::user()->role == 'organization')
                        <div class="col-md-3 p-0 m-0">
                            <button type="button" class="btn btn-danger btn-sm" disabled>rejected</button>
                        </div>
                    @elseif(Auth::user()!=null && Auth::user()->id == $circular->Event->Organization->user_id)
                        <div class="col-md-3 p-0 m-0">
                            <form action="{{route('circular.validateRequest', [$circular->Event->id, $circular->id, $participant->id])}}" method="POST">
                                @csrf
                                <input id="status" type="hidden" name="status" value="rejected">
                                <button type="submit" class="btn btn-danger btn-sm">reject</button>
                            </form>
                        </div>
                    @elseif($status == 'pending')
                        <div class="col-md-3 p-0 m-0">
                            <button type="button" class="btn btn-success btn-sm" disabled>pending</button>
                        </div>
                    @endif
                    
                </div>
            @endforeach
        </div>
    </div>
@endsection