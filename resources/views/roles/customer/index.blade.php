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
    @elseif (request()->is('profile'))
        @include('roles.customer.__profile')
    @elseif (request()->is('borrowed-books'))
        @include('roles.customer.borrowed_books')
    @elseif (request()->is('borrowing-history'))
        @include('roles.customer.borrowing_history')
    @elseif (request()->is('bookmarks'))
        @include('roles.customer.__bookmarks')
    @endif
@endsection
