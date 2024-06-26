<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

<!-- Container untuk kartu-kartu -->
<div class="container-fluid p-4">
    @if ($popularBooksDetails)
        <h4>Popular</h4>
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 gap-2 mt-3 justify-content-center" id="container-book">
            @foreach ($popularBooksDetails as $book)
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
                            style="font-size: 14px" data-bs-toggle="modal"
                            data-bs-target="#detailBook_{{ $book->id }}">
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
                        <button type="button" class="btn btn-outline-info"
                            onclick="toggleBookmark({{ $book->id }})">
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
    @endif


    <h4>New Book</h4>
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 gap-2 mt-3 justify-content-center" id="container-book">
        @foreach ($newBooks as $book)
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
                        style="font-size: 14px" data-bs-toggle="modal"
                        data-bs-target="#detailBook_{{ $book->id }}">
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
</script>
