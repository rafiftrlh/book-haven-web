<!-- Modal -->
<div class="modal fade" id="detailBook_{{ $book->id }}" tabindex="-1" role="dialog" aria-labelledby="detailBookLabel"
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
                    <img src="{{ $book->cover_url }}" alt="img-blur-shadow" class="shadow border-radius-lg"
                        style="width: 100%;">
                </a>
                <div class="my-auto px-0">
                    <div class="card-body text-left px-0">
                        <p style="font-size: 12px; font-weight: 600" class="mb-1 pt-0 text-muted">
                            Stock : {{ $book->stock }}</p>
                        <p style="text-transform: capitalize;" class="text-success mb-2 text-sm">
                            @foreach ($book->categories as $index => $c)
                                {{ $c->name }}@if (!$loop->last)
                                    •
                                @endif
                            @endforeach
                        </p>
                        <p style="text-transform: uppercase; font-size: 12px; font-weight: 600" class="mb-1 text-muted">
                            {{ $book->language }} | &starf; {{ $book->total_rating }}</p>
                        <div class="p-md-0 pt-3">
                            <h5 class="font-weight-bolder mb-0" style="text-transform: capitalize">
                                {{ $book->title_book }}</h5>
                        </div>
                        <p style="text-transform: capitalize;font-size: 12px; font-weight: 600" class="text-muted">
                            By :
                            @foreach ($book->authors as $index => $a)
                                {{ $a->name }}@if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </p>

                        <p class="mb-1 h6">Synopsis: </p>
                        <p class="mb-4">{{ $book->synopsis }}</p>

                        <div class="border-top pt-2">
                            <p class="mb-1 h6">Ulasan: </p>
                            <div class="reviews-container" style="max-height: 300px; overflow-y: auto;">
                                <ul class="list-unstyled">
                                    @forelse ($book->reviews as $r)
                                        <li class="border mb-3 p-2 rounded">
                                            <span class="text-bold">{{ $r->user->username }} : </span>
                                            {{ $r->review }}
                                            <div class="rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $r->rating)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </li>
                                    @empty
                                        <li class="text-muted">Belum ada ulasan untuk buku ini.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <form id="borrow-form-{{ $book->id }}" action="{{ route('borrows.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <button type="button"
                        class="btn @if ($book->stock == 0) btn-secondary @else bg-gradient-primary @endif"
                        @if ($book->stock == 0) @disabled(true) @endif
                        onclick="confirmBorrow({{ $book->id }})">Borrow</button>
                </form>
                <form action="" method="post">
                    <button type="submit" class="btn btn-outline-info">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-bookmark-star" viewBox="0 0 16 16">
                            <path
                                d="M7.84 4.1a.178.178 0 0 1 .32 0l.634 1.285a.18.18 0 0 0 .134.098l1.42.206c.145.021.204.2.098.303L9.42 6.993a.18.18 0 0 0-.051.158l.242 1.414a.178.178 0 0 1-.258.187l-1.27-.668a.18.18 0 0 0-.165 0l-1.27.668a.178.178 0 0 1-.257-.187l.242-1.414a.18.18 0 0 0-.05-.158l-1.03-1.001a.178.178 0 0 1 .098-.303l1.42-.206a.18.18 0 0 0 .134-.098z" />
                            <path
                                d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/css/multi-select-tag.css">
<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/js/multi-select-tag.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new MultiSelectTag('categories_{{ $book->id }}', {
            rounded: true,
            placeholder: 'Search',
            tagColor: {
                textColor: '#327b2c',
                borderColor: '#92e681',
                bgColor: '#eaffe6',
            },
            onChange: function(values) {
                console.log('Categories for book {{ $book->id }}:', values);
            }
        });

        new MultiSelectTag('authors_{{ $book->id }}', {
            rounded: true,
            placeholder: 'Search',
            tagColor: {
                textColor: '#327b2c',
                borderColor: '#92e681',
                bgColor: '#eaffe6',
            },
            onChange: function(values) {
                console.log('Authors for book {{ $book->id }}:', values);
            }
        });
    });
</script>
