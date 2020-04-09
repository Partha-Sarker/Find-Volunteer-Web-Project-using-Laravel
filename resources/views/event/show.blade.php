@extends('layouts.app')

{{-- @section('stylesheet_script')
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
@endsection --}}

@section('title',"| $event->name")

@section('content')
    <div class="text-center">
        <h2>{{$event->name}} <strong> by </strong><a style="text-decoration:none" href="{{route('organization.show', $organization)}}">{{$organization->name}}</a></h2>
    </div>
    <div class="row">
        <div class="col-md-3">
            {{-- this is slideshow --}}

            {{-- this is gallery --}}
            <div class="card mb-2">
                <div class="card-header">Gallery</div>
                <div class="card-body">
                    <div class="row">
                        @if (count($photos)>0)
                            @foreach ($photos as $photo)
                                <div class="col-md-6 mb-2">
                                    <a href="{{asset('images/'.$photo->photo)}}" class="btn btn-primary btn-sm"><img src="{{asset('images/'.$photo->photo)}}" width="130"></a>
                                    @auth
                                        @if (Auth::user()->id == $photo->Event->Organization->user_id)
                                            <form class="text-center" action="{{route('event_photo.destroy', [$event->id, $photo])}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm p-0">delete</button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @auth
                @if (Auth::user()->id == $event->Organization->user_id)
                    <form action="{{route('event_photo.store', $event->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-8">
                                <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*"`>
                            </div>
                            <div class="col-md-4">
                                <input type="submit" class= "btn btn-primary btn-block" value="Add Image">
                            </div>
                        </div>
                    </form>
                @endif
            @endauth
        </div>
        <div class="col-md-6">
            @auth
                @if (Auth::user()->id == $event->Organization->user_id)
                    <a href="{{route('circular.create', $event->id)}}" class="btn btn-success btn-block">Create Circular</a>
                @endif
            @endauth
            <hr>
            <h4><strong>Description: </strong>{{$event->description}}</h4>
            <hr>
            <div class="card">
                <div class="card-header text-center">Circulars</div>
                <div class="card-body">
                    @if (count($circulars)>0)
                        @foreach ($circulars as $circular)
                            @include('partials._circular')
                        @endforeach
                    @else
                        <h3 class="text-center">No Circular</h3>
                    @endif
                    
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <a href="{{asset('images/'.$event->default_image)}}"><img class="img-thumbnail mx-auto my-0 d-block" src="{{asset('images/'.$event->default_image)}}" width="250"></a>
            <br><br>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            Type
                        </div>
                        <div class="col-md-7">
                            {{$event->type}}
                        </div>
                        <div class="col-md-5">
                            Status
                        </div>
                        <div class="col-md-7">
                            {{$event->status}}
                        </div>
                        <div class="col-md-5">
                            Event Created
                        </div>
                        <div class="col-md-7">
                                {{date('d M Y', strtotime($event->created_at))}}
                        </div>
                        <div class="col-md-5">
                            Start Time
                        </div>
                        <div class="col-md-7">
                                {{date('d M Y g:ia', strtotime($event->start_time))}}
                        </div>
                        <div class="col-md-5">
                            End Time
                        </div>
                        <div class="col-md-7">
                                {{date('d M Y g:ia', strtotime($event->end_time))}}
                        </div>
                    </div>
                    <br>
                    @auth
                        @if (Auth::user()->id == $event->Organization->user_id)
                            <form class="" action="{{route('event.destroy', $event)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <a href="{{route('event.edit',$event)}}" class="btn btn-primary">Edit Event</a>
                                <button type="submit" class="btn btn-danger float-right">Delete</button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection