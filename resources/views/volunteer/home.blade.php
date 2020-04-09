@extends('home')

@section('stylesheet_script')
    <script src="https://kit.fontawesome.com/26eaf231a6.js"></script>
@endsection

@section('left_section')
    @include('partials._top_volunteers')
@endsection

@section('right_section')
    <p><strong>My Circulars</strong></p>
    <hr>
    @include('partials._my_circulars')
@endsection