@extends('layouts.main_index')
@section('navbar')
    @include('partials.index.__navbar')
@endsection

@section('sidebar')
    @include('partials.index.__sidebar_admin')
@endsection

@section('content')
    @if (request()->is('admin'))
        @include('roles.admin.__data_user')
    @elseif (request()->is('admin/categories'))
        @include('roles.admin.__data_categories')
    @endif
@endsection
