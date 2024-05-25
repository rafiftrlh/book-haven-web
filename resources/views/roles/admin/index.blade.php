@extends('layouts.main_index')
@section('navbar')
    @include('partials.index.__navbar')
@endsection

@section('sidebar')
    @include('partials.index.__sidebar_admin')
@endsection

@section('content')
    @if (request()->is('admin'))
        @include('roles.admin.__home')
    @elseif (request()->is('admin/users'))
        @include('roles.admin.__data_users')
    @elseif (request()->is('admin/books'))
        @include('roles.admin.__data_books')
    @elseif (request()->is('admin/books-create'))
        @include('roles.admin.inner_page.__create_book_page')
    @elseif (request()->is('admin/categories'))
        @include('roles.admin.__data_categories')
    @elseif (request()->is('admin/authors'))
        @include('roles.admin.__data_authors')
    @endif
@endsection
