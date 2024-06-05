<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<style>
    .star {
        cursor: pointer;
        font-size: 24px;
        color: #ccc;
        transition: color 0.2s;
    }

    .star.rated {
        color: #ffc107;
        /* Warna bintang terpilih */
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header bg-primary text-white">{{ __('Borrowing History') }}</div>

                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($borrowingHistory as $borrow)
                            <li class="list-group-item" data-toggle="modal" data-target="#reviewModal_{{ $borrow->id }}">
                                @include('partials.modals.customer.__review_book')
                                <strong>{{ $borrow->books->title_book }}</strong>
                                @if ($borrow->return_date)
                                    @if ($borrow->return_date instanceof \Carbon\Carbon)
                                        (Returned: {{ $borrow->return_date->format('d M Y') }})
                                    @else
                                        (Returned: {{ \Carbon\Carbon::parse($borrow->return_date)->format('d M Y') }})
                                    @endif
                                @else
                                    (Not returned)
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

