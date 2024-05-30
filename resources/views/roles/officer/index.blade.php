@extends('layouts.main_index')

@section('navbar')
    @include('partials.index.__navbar')
@endsection

@section('sidebar')
    @include('partials.index.__sidebar_officer')
@endsection

@section('content')
    @if (request()->is('officer'))
        @include('roles.officer.__home_officer')
    @elseif (request()->is('officer/data_buku'))
        @include('roles.officer.__data_buku')
    @elseif (request()->is('officer/books_create'))
        @include('roles.officer.__books_create')
    @elseif (request()->is('officer/add-category'))
        @include('roles.officer.__add_category')
    @elseif (request()->is('officer/confirm_peminjaman'))
        @include('roles.officer.__confirm_peminjaman')
    @elseif (request()->is('officer/add_author'))
        @include('roles.officer.__add_author')
    @endif
@endsection