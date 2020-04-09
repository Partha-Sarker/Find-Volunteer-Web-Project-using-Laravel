@extends('layouts.app')
@section('title',"| Organizations")
@section('content')
    <div class="row">
        <div class="col-md-3">
            @auth
                @if (Auth::user()->role=='organization')
                    @include('partials._my_events')
                    <hr>
                    @include('partials._top_volunteers')
                @else 
                    @include('partials._top_volunteers')
                @endif
            @endauth
        </div>
        <div class="col-md-6">
            <form autocomplete="off">
                <input id="search_item" type="text" class="form-control" name="search" placeholder="search organization">
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
            @if (count($organizations)>0)
                @foreach ($organizations as $organization)
                    <div class="card mb-2">
                        <div class="card-header">
                            <a href="{{route('organization.show', $organization)}}" class="btn btn-light btn-lg py-0 px-0">{{$organization->name}}</a>
                            <span class="float-right px-1 text-white bg-primary border rounded">members: {{count($organization->Member)}}</span>
                            <span class="float-right px-1 text-white bg-success border rounded"> events: {{count($organization->Event)}}</span>
                        </div>
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">Founded On: {{date('d M Y', strtotime($organization->founded_on))}}</h6>
                            <p class="h5 card-text mt-2">{{$organization->description}}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <h2 class="text-center">No organization</h2>
            @endif
            <br>
            <ul class="pagination justify-content-center">{{ $organizations->links() }}</ul>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <h5><strong>Number Of Organizations:</strong></h5>
                        </div>
                        <div class="col-md-3">
                            <h5>{{count($organizations)}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection