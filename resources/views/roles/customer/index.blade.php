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
    @elseif (request()->is('book-catalog'))
        @include('roles.customer.__book_catalog')
    @elseif (request()->is('notification'))
        @include('roles.customer.__notification')
    @endif
@endsection
