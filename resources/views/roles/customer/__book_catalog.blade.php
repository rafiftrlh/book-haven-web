<style>
    .btnCategory {
        background-color: white;
        /* Original background color */
        color: black;
    }
</style>

<div class="mt-4">
    <input type="text" id="search" class="form-control" placeholder="Search book...">
</div>
<div class="container-fluid p-4">
    {{-- List Category --}}
    <p class="h5 category">Category list</p>
    <div style="overflow-x: auto; overflow-y: hidden; display: flex; gap: 5px;">
        @foreach ($categories as $category)
            <button type="button" class="btn btnCategory btn-secondary category-filter"
                style="text-transform: capitalize;" data-category-id="{{ $category->id }}">
                {{ $category->name }}
            </button>
        @endforeach
    </div>

    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 gap-2 mt-3 justify-content-center" id="container-book">
        @foreach ($books as $book)
            <div class="card p-3" style="height: fit-content; width: 230px;">
                <div class="position-relative">
                    <a class="d-block blur-shadow-image">
                        <img src="{{ $book->cover_url }}" alt="img-blur-shadow" class="shadow border-radius-lg"
                            style="width: 100%;">
                    </a>
                </div>
                <div class="card-body px-0 pt-3 pb-0">
                    <p style="font-size: 12px; font-weight: 600" class="mb-1 pt-0 text-muted">
                        Stock : {{ $book->stock }}
                    </p>
                    <p style="text-transform: capitalize; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2;"
                        class="text-success mb-2 text-sm">
                        @foreach ($book->categories as $index => $c)
                            {{ $c->name }}@if (!$loop->last)
                                •
                            @endif
                        @endforeach
                    </p>
                    <p style="text-transform: uppercase; font-size: 12px; font-weight: 600" class="mb-1 text-muted">
                        {{ $book->language }} | &starf; {{ $book->total_rating }}</p>
                    <a style="text-transform: capitalize;">
                        <h5>{{ $book->title_book }}</h5>
                    </a>
                    <p style="text-transform: capitalize; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 1; font-size: 12px; font-weight: 600"
                        class="text-muted">
                        By :
                        @foreach ($book->authors as $index => $a)
                            {{ $a->name }}@if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </p>

                    <button type="button" class="text-info icon-move-right pull-right no-style-button fw-bold"
                        style="font-size: 14px" data-bs-toggle="modal" data-bs-target="#detailBook_{{ $book->id }}">
                        Read More <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                    </button>
                    @include('partials.modals.customer.__detail_book')
                </div>
                <div class="card-footer d-flex justify-content-between p-0 mt-3 pt-4"
                    style="border-top: 2px solid rgba(128, 128, 128, 0.21)">
                    <button type="button"
                        class="btn @if ($book->stock == 0) btn-secondary @else bg-gradient-primary @endif"
                        @if ($book->stock == 0) @disabled(true) @endif
                        onclick="confirmBorrow({{ $book->id }})">Borrow</button>
                    <button type="button" class="btn btn-outline-info" onclick="toggleBookmark({{ $book->id }})">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-bookmark-star" viewBox="0 0 16 16">
                            <path
                                d="M7.84 4.1a.178.178 0 0 1 .32 0l.634 1.285a.18.18 0 0 0 .134.098l1.42.206c.145.021.204.2.098.303L9.42 6.993a.18.18 0 0 0-.051.158l.242 1.414a.178.178 0 0 1-.258.187l-1.27-.668a.18.18 0 0 0-.165 0l-1.27.668a.178.178 0 0 1-.257-.187l.242-1.414a.18.18 0 0 0-.05-.158l-1.03-1.001a.178.178 0 0 1 .098-.303l1.42-.206a.18.18 0 0 0 .134-.098z" />
                            <path
                                d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z" />
                        </svg>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function confirmBorrow(bookId) {
        Swal.fire({
            title: 'Are you sure you want to borrow this book?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, borrow it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Make AJAX call to check for borrowing conditions and submit the form if conditions are met
                $.ajax({
                    url: "{{ route('borrows.store') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_id: "{{ Auth::user()->id }}",
                        book_id: bookId
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'The book has been borrowed successfully. Wait for approval and then you can pick it up.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Optionally, you can refresh the page or update the UI here
                            location.reload();
                        });
                    },
                    error: function(response) {
                        var errorMessage = response.responseJSON.message;
                        Swal.fire({
                            title: 'Failed!',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    }

    function toggleBookmark(bookId) {
        Swal.fire({
            title: 'Are you sure you want to toggle bookmark?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, toggle it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Make AJAX call to check for borrowing conditions and submit the form if conditions are met
                $.ajax({
                    url: "{{ route('bookmarks.storeOrDelete') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_id: "{{ Auth::id() }}",
                        book_id: bookId
                    },
                    success: function(response) {
                        var successMessage = response.message;
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: successMessage,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Optionally, you can refresh the page or update the UI here
                            location.reload();
                        });
                    },
                    error: function(response) {
                        var errorMessage = response.responseJSON.message;
                        Swal.fire({
                            title: 'Failed!',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    }

    function updateBookTable(data) {
        var tableBody = $('#container-book');
        tableBody.empty();
        data.forEach(function(book) {
            console.log(book.cover_url);
            var bookRow = `
            <div class="card p-3" style="height: fit-content; width: 230px;">
                <div class="position-relative">
                    <a class="d-block blur-shadow-image">
                        <img src="${book.cover_url}" alt="img-blur-shadow" class="shadow border-radius-lg"
                            style="width: 100%;">
                    </a>
                </div>
                <div class="card-body px-0 pt-3 pb-0">
                    <p style="font-size: 12px; font-weight: 600" class="mb-1 pt-0 text-muted">
                        Stock : ${book.stock}
                    </p>
                    <p style="text-transform: capitalize; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2;"
                        class="text-success mb-2 text-sm">
                        ${book.categories.map((c, index) => `${c.name}${index < book.categories.length - 1 ? ' • ' : ''}`).join('')}
                    </p>
                    <p style="text-transform: uppercase; font-size: 12px; font-weight: 600" class="mb-1 text-muted">
                        ${book.language} | &starf; 4.6
                    </p>
                    <a style="text-transform: capitalize;">
                        <h5>${book.title_book}</h5>
                    </a>
                    <p style="text-transform: capitalize; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 1; font-size: 12px; font-weight: 600"
                        class="text-muted">
                        By : ${book.authors.map((a, index) => `${a.name}${index < book.authors.length - 1 ? ', ' : ''}`).join('')}
                    </p>

                    <button type="button" class="text-info icon-move-right pull-right no-style-button fw-bold"
                        style="font-size: 14px" data-bs-toggle="modal" data-bs-target="#detailBook_${book.id}">
                        Read More <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                    </button>
                    <div class="modal fade" id="detailBook_${book.id}" tabindex="-1" role="dialog" aria-labelledby="detailBookLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered position-relative" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailBookLabel">Detail Book
                                </h5>
                                <button class="btn btn-link text-dark p-0" style="position: absolute; top:20px; right: 20px;"
                                    data-bs-dismiss="modal">
                                    <i class="fa fa-close" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <a class="d-block blur-shadow-image">
                                    <img src="${book.cover_url}" alt="img-blur-shadow" class="shadow border-radius-lg"
                                        style="width: 100%;">
                                </a>
                                <div class="my-auto px-0">
                                    <div class="card-body text-left px-0">
                                        <p style="font-size: 12px; font-weight: 600" class="mb-1 pt-0 text-muted">
                                            Stock : ${book.stock}</p>
                                        <p style="text-transform: capitalize;" class="text-success mb-2 text-sm">
                                            ${book.categories.map(c => c.name).join(' • ')}</p>
                                        <p style="text-transform: uppercase; font-size: 12px; font-weight: 600" class="mb-1 text-muted">
                                            ${book.language} | &starf; ${book.total_rating}</p>
                                        <div class="p-md-0 pt-3">
                                            <h5 class="font-weight-bolder mb-0" style="text-transform: capitalize">
                                                ${book.title_book}</h5>
                                        </div>
                                        <p style="text-transform: capitalize;font-size: 12px; font-weight: 600" class="text-muted">
                                            By : ${book.authors.map(a => a.name).join(', ')}</p>

                                        <p class="mb-1 h6">Synopsis: </p>
                                        <p class="mb-4">${book.synopsis}</p>

                                        <div class="border-top pt-2">
                                            <p class="mb-1 h6">Ulasan: </p>
                                            <div class="reviews-container" style="max-height: 300px; overflow-y: auto;">
                                                <ul class="list-unstyled">
                                                    ${book.reviews.length > 0 ?
                                                        book.reviews.map(r => `
                                                            <li class="border mb-3 p-2 rounded">
                                                                <span class="text-bold">${r.user.username} : </span>
                                                                ${r.review}
                                                                <div class="rating">
                                                                    ${Array.from({ length: 5 }, (_, i) => `
                                                                        ${i < r.rating ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>'}
                                                                    `).join('')}
                                                                </div>
                                                            </li>
                                                        `).join('') :
                                                        '<li class="text-muted">Belum ada ulasan untuk buku ini.</li>'
                                                    }
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button"
                                    class="btn ${book.stock == 0 ? 'btn-secondary' : 'bg-gradient-primary'}"
                                    ${book.stock == 0 ? 'disabled' : ''} onclick="confirmBorrow(${book.id})">Borrow</button>
                                <button type="button" class="btn btn-outline-info" onclick="toggleBookmark(${book.id})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-bookmark-star" viewBox="0 0 16 16">
                                        <path
                                            d="M7.84 4.1a.178.178 0 0 1 .32 0l.634 1.285a.18.18 0 0 0 .134.098l1.42.206c.145.021.204.2.098.303L9.42 6.993a.18.18 0 0 0-.051.158l.242 1.414a.178.178 0 0 1-.258.187l-1.27-.668a.18.18 0 0 0-.165 0l-1.27.668a.178.178 0 0 1-.257-.187l.242-1.414a.18.18 0 0 0-.05-.158l-1.03-1.001a.178.178 0 0 1 .098-.303l1.42-.206a.18.18 0 0 0 .134-.098z" />
                                        <path
                                            d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="card-footer d-flex justify-content-between p-0 mt-3 pt-4"
                    style="border-top: 2px solid rgba(128, 128, 128, 0.21)">
                    <button type="button"
                        class="btn ${book.stock == 0 ? 'btn-secondary' : 'bg-gradient-primary'}"
                        ${book.stock == 0 ? 'disabled' : ''}
                        onclick="confirmBorrow(${book.id})">Borrow</button>
                    <button type="button" class="btn btn-outline-info" onclick="toggleBookmark(${book.id})">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-bookmark-star" viewBox="0 0 16 16">
                            <path
                                d="M7.84 4.1a.178.178 0 0 1 .32 0l.634 1.285a.18.18 0 0 0 .134.098l1.42.206c.145.021.204.2.098.303L9.42 6.993a.18.18 0 0 0-.051.158l.242 1.414a.178.178 0 0 1-.258.187l-1.27-.668a.18.18 0 0 0-.165 0l-1.27.668a.178.178 0 0 1-.257-.187l.242-1.414a.18.18 0 0 0-.05-.158l-1.03-1.001a.178.178 0 0 1 .098-.303l1.42-.206a.18.18 0 0 0 .134-.098z" />
                            <path
                                d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z" />
                        </svg>
                    </button>
                </div>
            </div>
          `;
            tableBody.append(bookRow);
        });
    }

    $(document).ready(function() {
        $('#search').on('keyup', function() {
            var query = $(this).val();
            $.ajax({
                url: '{{ route('customer.searchBooks') }}',
                type: 'GET',
                data: {
                    query: query
                },
                success: function(data) {
                    updateBookTable(data);
                    console.log(data);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    });

    $('.category-filter').click(function() {
        var categoryId = $(this).data('category-id');
        $.ajax({
            url: '{{ route('filter.books.by.category') }}',
            method: 'GET',
            data: {
                category_id: categoryId
            },
            success: function(response) {
                updateBookTable(response.books);
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.btn.category-filter');

        buttons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove the 'active' class from all buttons
                buttons.forEach(btn => btn.classList.remove('active'));
                // Add the 'active' class to the clicked button
                this.classList.add('active');
            });
        });
    });
</script>
