<div class="container-fluid p-4">
    <div class="row">
        <div class="col-12">
            <a href="{{ route('officer.books_create') }}" type="button" class="btn bg-gradient-primary">Create Book</a>
            <br>
            <div class="mt-4">
                <input type="text" id="search" class="form-control" placeholder="Search book...">
            </div>
            <div class="card mb-4 mt-4">
                <div class="card-header pb-0">
                    <h6>Books Data</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">Book Code</th>
                                    <th class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">Title</th>
                                    <th class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">Author</th>
                                    <th class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">Category</th>
                                    <th class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">Stock</th>
                                    <th class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody id="book-table-body">
                                @foreach ($books as $book)
                                <tr>
                                    <td>
                                        <p class="text-xs text-secondary mb-0 px-3" style="text-transform: uppercase;">{{ $book->book_code }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0 px-3" style="text-transform: capitalize;">{{ $book->title_book }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0 px-3" style="text-transform: capitalize;">
                                            @php
                                            $totalAuthors = count($book->authors);
                                            @endphp

                                            @foreach ($book->authors as $index => $a)
                                            {{ $a->name }}
                                            @if ($index + 1 < $totalAuthors)
                                            ,
                                            @endif
                                            @endforeach
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0 px-3" style="text-transform: capitalize;">
                                            @php
                                            $totalCategories = count($book->categories);
                                            @endphp

                                            @foreach ($book->categories as $index => $c)
                                            {{ $c->name }}
                                            @if ($index + 1 < $totalCategories)
                                            ,
                                            @endif
                                            @endforeach
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0 px-3">{{ $book->stock }}</p>
                                    </td>
                                    <td class="d-flex gap-3 px-3">
                                        <button type="button" class="btn bg-gradient-info" data-bs-toggle="modal" data-bs-target="#editBook_{{ $book->id }}" data-book-id="{{ $book->id }}">Edit</button>
                                        @include('partials.modals.admin.book.__edit_book')
                                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function updateBookTable(data) {
        var tableBody = $('#book-table-body');
        tableBody.empty();

        if (data.length === 0) {
            var noResultRow = `
                <tr>
                    <td colspan="6"><p class="text-xl text-secondary mb-0 px-3 text-center">Data yang Anda cari tidak ditemukan.</p></td>
                </tr>
            `;
            tableBody.append(noResultRow);
        } else {
            data.forEach(function(book) {
                var bookRow = `
                    <tr>
                        <td><p class="text-xs text-secondary mb-0 px-3">${book.book_code}</p></td>
                        <td><p class="text-xs text-secondary mb-0 px-3" style="text-transform: capitalize;">${book.title_book}</p></td>
                        <td>
                            <p class="text-xs text-secondary mb-0 px-3" style="text-transform: capitalize;">`;
                            // Authors loop
                            var totalAuthors = book.authors.length;
                            book.authors.forEach(function(author, index) {
                                bookRow += `${author.name}`;
                                if (index + 1 < totalAuthors) {
                                    bookRow += `, `;
                                }
                            });
                            bookRow += `</p>
                        </td>
                        <td>
                            <p class="text-xs text-secondary mb-0 px-3" style="text-transform: capitalize;">`;
                            // Categories loop
                            var totalCategories = book.categories.length;
                            book.categories.forEach(function(category, index) {
                                bookRow += `${category.name}`;
                                if (index + 1 < totalCategories) {
                                    bookRow += `, `;
                                }
                            });
                            bookRow += `</p>
                        </td>
                        <td><p class="text-xs text-secondary mb-0 px-3">${book.stock}</p></td>
                        <td class="d-flex gap-3">
                            <button type="button" class="btn bg-gradient-info" data-bs-toggle="modal" data-bs-target="#editBook_${book.id}" data-book-id="${book.id}">Edit</button>
                            <!-- Modal -->
                            <form action="/api/books/${book.id}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                `;
                tableBody.append(bookRow);
            });
        }
    }

    $(document).ready(function() {
        $('#btn-all').addClass('btn-info');

        $('#search').on('keyup', function() {
            var query = $(this).val();
            $.ajax({
                url: '{{ route('admin.searchBooks') }}',
                type: 'GET',
                data: {
                    query: query
                },
                success: function(data) {
                    updateBookTable(data.books); // Assuming 'books' is the key containing books data
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    });
</script>

