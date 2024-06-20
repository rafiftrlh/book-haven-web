<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/css/multi-select-tag.css">
<div class="container-fluid p-4">
    <div class="row">
        <div class="col-12">
            <a href="{{ route('admin.books.create') }}" type="button" class="btn bg-gradient-primary">
                Create Book
            </a>
            <br>
            <div class="mt-4">
                <input type="text" id="search" class="form-control" placeholder="Search book...">
            </div>
            <div class="card mb-4 mt-4">
                <div class="card-header pb-0 d-flex gap-1">
                    <h6>Books Data</h6>
                    <span class="text-primary"
                        style="font-size: 14px; font-weight: 700; margin-right: 2px; margin-top: 2px;">
                        @if ($totalBook > 99)
                            99+
                        @else
                            {{ $totalBook }}
                        @endif
                    </span>
                </div>
                @if ($totalBook == 0)
                    <div class="card-body px-0 pt-0 pb-4">
                        <p class="h4 text-secondary" style="text-align: center">
                            No Book Data
                        </p>
                    </div>
                @else
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                            Book Code</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                            Title</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                            Stock</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                            Unit Price</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody id="book-table-body">
                                    @foreach ($books as $book)
                                        <tr>
                                            <td>
                                                <p class="text-xs text-secondary mb-0 px-3"
                                                    style="text-transform: uppercase;">{{ $book->book_code }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs text-secondary mb-0 px-3"
                                                    style="text-transform: capitalize;">{{ $book->title_book }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs text-secondary mb-0 px-3">{{ $book->stock }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs text-secondary mb-0 px-3">{{ $book->price }}</p>
                                            </td>
                                            <td class="d-flex gap-3 px-3">
                                                <button type="button" class="btn bg-gradient-info"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editBook_{{ $book->id }}"
                                                    data-book-id="{{ $book->id }}">Edit</button>
                                                @include('partials.modals.admin.book.__edit_book')
                                                <form action="{{ route('books.destroy', $book->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this book?');">
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
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/js/multi-select-tag.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function updateBookTable(data) {
        var tableBody = $('#book-table-body');
        tableBody.empty();
        if (data.length === 0) {
            tableBody.append(`
            <tr>
                <td colspan="5">
                    <div class="card-body px-0 pt-0 pb-0">
                        <p class="h4 text-secondary" style="text-align: center">
                            No Book Data
                        </p>
                    </div>
                </td>
            </tr>
        `);
        } else {
            data.forEach(function(book) {
                var bookRow = `
                <tr>
                    <td><p class="text-xs text-secondary mb-0 px-3">${book.book_code}</p></td>
                    <td><p class="text-xs text-secondary mb-0 px-3" style="text-transform: capitalize;">${book.title_book}</p></td>
                    <td><p class="text-xs text-secondary mb-0 px-3" style="text-transform: capitalize;">${book.stock}</p></td>
                    <td><p class="text-xs text-secondary mb-0 px-3">${book.price}</p></td>
                    <td class="d-flex gap-3">
                        <button type="button" class="btn bg-gradient-info" data-bs-toggle="modal" data-bs-target="#editBook_${book.id}" data-book-id="${book.id}">Edit</button>
                        <div class="modal fade" id="editBook_${book.id}" tabindex="-1" role="dialog" aria-labelledby="editBookLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered position-relative" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editBookLabel">Edit Book</h5>
                                        <button class="btn btn-link text-dark p-0" style="position: absolute; top:20px; right: 20px;" data-bs-dismiss="modal">
                                            <i class="fa fa-close" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/api/books/${book.id}" method="POST" enctype="multipart/form-data">
                                            @method('PATCH')
                                            @csrf
                                            <div class="modal-body container-fluid">
                                                <label for="book_code" class="form-label">Book Code</label>
                                                <input autocomplete="off" type="text" autofocus class="form-control" id="book_code" name="book_code" value="${book.book_code}">
                                                <label for="title_book" class="form-label">Title Book</label>
                                                <input autocomplete="off" type="text" autofocus class="form-control" id="title_book" name="title_book" value="${book.title_book}">
                                                <label for="cover" class="form-label">Cover</label>
                                                <br>
                                                <div class="position-relative">
                                                    <a class="d-block blur-shadow-image">
                                                        <img src="${book.cover_url}" alt="img-blur-shadow" class="shadow border-radius-lg" style="width: 100%;">
                                                    </a>
                                                </div>
                                                <div class="mt-3">
                                                    <input autocomplete="off" type="file" class="form-control" id="cover" name="cover" value="${book.cover}">
                                                </div>
                                                <label for="language" class="form-label">Language</label>
                                                <input autocomplete="off" type="text" class="form-control" id="language" name="language" value="${book.language}">
                                                <label for="stock" class="form-label">Stock</label>
                                                <input autocomplete="off" type="number" class="form-control" id="stock" name="stock" value="${book.stock}">
                                                <label for="price" class="form-label">Unit Price</label>
                                                <input autocomplete="off" type="number" class="form-control" id="price" name="price" value="${book.price}">
                                                <label for="categories" class="form-label">Categories</label>
                                                <select name="categories[]" id="categories_${book.id}" multiple class="form-control">
                                                    ${book.categories.map(category => `<option value="${category.id}" selected>${category.name}</option>`).join('')}
                                                </select>
                                                <label for="authors" class="form-label">Authors</label>
                                                <select name="authors[]" id="authors_${book.id}" multiple class="form-control">
                                                    ${book.authors.map(author => `<option value="${author.id}" selected>${author.name}</option>`).join('')}
                                                </select>
                                                <label for="synopsis" class="form-label">Synopsis</label>
                                                <textarea required autocomplete="off" cols="20" rows="10" type="text" class="form-control" id="synopsis" name="synopsis">${book.synopsis}</textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn bg-gradient-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="/api/books/${book.id}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            `;
                tableBody.append(bookRow);
                initializeMultiSelectTags(book.id);
            });
        }
    }

    $(document).ready(function() {
        $('#search').on('keyup', function() {
            var query = $(this).val();
            $.ajax({
                url: '{{ route('admin.searchBooks') }}',
                type: 'GET',
                data: {
                    query: query
                },
                success: function(response) {
                    updateBookTable(response.books);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    });

    function initializeMultiSelectTags(bookId) {
        new MultiSelectTag(`categories_${bookId}`, {
            rounded: true,
            placeholder: 'Search',
            tagColor: {
                textColor: '#327b2c',
                borderColor: '#92e681',
                bgColor: '#eaffe6',
            },
            onChange: function(values) {
                console.log(`Categories for book ${bookId}:`, values);
            }
        });

        new MultiSelectTag(`authors_${bookId}`, {
            rounded: true,
            placeholder: 'Search',
            tagColor: {
                textColor: '#327b2c',
                borderColor: '#92e681',
                bgColor: '#eaffe6',
            },
            onChange: function(values) {
                console.log(`Authors for book ${bookId}:`, values);
            }
        });
    }
</script>
