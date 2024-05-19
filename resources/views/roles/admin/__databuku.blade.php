<!-- resources/views/books/index.blade.php -->
@extends('layout')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2>Daftar Buku</h2>
            <a href="{{ route('books.create') }}" class="btn btn-success">Tambah Buku</a>
            @if ($message = Session::get('success'))
                <div class="alert alert-success mt-2">
                    {{ $message }}
                </div>
            @endif
            <table class="table table-bordered mt-2">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Tahun</th>
                    <th>Cover</th>
                    <th width="280px">Aksi</th>
                </tr>
                @foreach ($books as $book)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->year }}</td>
                    <td>
                        @if ($book->cover)
                            <img src="{{ asset('covers/'.$book->cover) }}" width="50">
                        @else
                            Tidak ada cover
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST">
                            <a class="btn btn-info" href="{{ route('books.show', $book->id) }}">Lihat</a>
                            <a class="btn btn-primary" href="{{ route('books.edit', $book->id) }}">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
