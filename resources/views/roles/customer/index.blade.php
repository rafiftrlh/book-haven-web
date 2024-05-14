@extends('layouts.main_index')

@section('navbar')
    @include('partials.index.__navbar')
@endsection

@section('sidebar')
    @include('partials.index.__sidebar')
@endsection

    @section('content')
        @if (request()->is('home'))
            @include('roles.customer.__book')
        @elseif (request()->is('bookcatalog'))
            @include('roles.customer.__bookcatalog')
        @elseif  (request()->is('notification'))
        @include('roles.customer.__notification')
        @endif
    @endsection
