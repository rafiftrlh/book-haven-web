<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5 ms-4">
                <div class="card-header bg-primary text-white">{{ __('Profile') }}</div>

                <div class="card-body">

                    <div class="mb-3 text-center ">
                        {{ $user->username }}
                    </div>
                    <div class="mb-3 text-center">
                        {{ $user->email }}
                    </div>


                    <p>{{ $user->address }}</p>
                    <div class="mb-3 te">
                        <strong>Joined On:</strong>
                        @if ($user->created_at)
                            @if ($user->created_at instanceof \Carbon\Carbon)
                                {{ $user->created_at->format('d M Y') }}
                            @else
                                {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}
                            @endif
                        @else
                            {{ __('No date available') }}
                        @endif
                    </div>

                    <a href="{{ route('borrowed_books_page') }}" class="btn btn-primary w-100 text-start">Borrowed
                        Books</a>


                    <a href="{{ route('borrowing_history') }}" class="btn btn-primary w-100 mt-3 text-start">Borrowing
                        History</a>

                    <a href="{{ route('customer.bookmarks') }}"
                        class="btn btn-primary w-100 mt-3 text-start">Bookmarks</a>

                </div>
            </div>
        </div>
    </div>
</div>
