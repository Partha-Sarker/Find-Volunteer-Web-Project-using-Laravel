@extends('layouts.app')
@section('title',"| Home")
@section('content')
    <div class="row">
        <div class="col-md-3">
            @yield('left_section')
        </div>
        <div class="col-md-6">
            <form autocomplete="off">
                <input id="search_item" type="text" class="form-control" name="search" placeholder="search circular">
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
            @if (count($circulars)>0)
                @foreach ($circulars as $circular)
                    @include('partials._circular')
                @endforeach
            @else
                <h2 class="text-center">No Circular</h2>
            @endif
            {{-- <br>
            <ul class="pagination justify-content-center">{{ $circulars->links() }}</ul> --}}
            <br><br>
        </div>
        <div class="col-md-3">
            @yield('right_section')
        </div>
    </div>
    
@endsection