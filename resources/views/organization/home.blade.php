@extends('home')

@section('left_section')
    @include('partials._my_events')
    <hr>
    @include('partials._top_volunteers')
@endsection

@section('right_section')
    @include('partials._my_members')
@endsection