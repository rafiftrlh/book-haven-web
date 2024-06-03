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

<script>
    function updateBookTable(data) {
        var tableBody = $('#book-table-body');
        tableBody.empty();
        data.forEach(function(book) {
            var bookRow = `
              <tr>
                  <td><p class="text-xs text-secondary mb-0 px-3">${book.book_code}</p></td>
                  <td><p class="text-xs text-secondary mb-0 px-3" style="text-transform: capitalize;">${book.title_book}</p></td>
                  <td><p class="text-xs text-secondary mb-0 px-3" style="text-transform: capitalize;">${book.stock}</p></td>
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
                    updateBookTable(data);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    });
</script>
