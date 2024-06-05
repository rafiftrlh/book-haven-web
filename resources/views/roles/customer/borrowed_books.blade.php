<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header bg-primary text-white">Borrowed Books</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($borrowedBooks as $borrow)
                            <li class="list-group-item d-flex align-items-center">
                                <div>
                                    <strong>{{ $borrow->book->title_book }}</strong>
                                    @if($borrow->due_date)
                                        @if($borrow->due_date instanceof \Carbon\Carbon)
                                            (Due: {{ $borrow->due_date->format('d M Y') }})
                                        @else
                                            (Due: {{ \Carbon\Carbon::parse($borrow->due_date)->format('d M Y') }})
                                        @endif
                                    @else
                                      <span class="ms-4">(Pending)</span>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
