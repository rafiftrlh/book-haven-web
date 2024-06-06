<div class="modal fade" id="reviewModal_{{ $borrow->id }}" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('review.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Write a Review {{ $borrow->books->title_book }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="book_id" id="book_id" value="{{ $borrow->book_id }}">
                    <div class="form-group">
                        <label for="review" class="col-form-label">Review:</label>
                        <textarea class="form-control" id="review" name="review"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="rating" class="col-form-label">Rating:</label>
                        <input type="hidden" id="rating" name="rating">
                        <div id="rating-stars">
                            <!-- Tambahkan elemen bintang rating di sini -->
                            <i class="star fas fa-star" data-index="1"></i>
                            <i class="star fas fa-star" data-index="2"></i>
                            <i class="star fas fa-star" data-index="3"></i>
                            <i class="star fas fa-star" data-index="4"></i>
                            <i class="star fas fa-star" data-index="5"></i>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Menangani klik pada bintang rating
        $('.star').on('click', function(event) {
            event.stopPropagation(); // Menghentikan penyebaran event

            var rating = $(this).data('index');
            var modalId = $(this).closest('.modal').attr('id');
            $('#' + modalId + ' input[name="rating"]').val(rating);

            // Reset warna bintang
            $('#' + modalId + ' .star').removeClass('rated');

            // Tandai bintang yang dipilih dan semua bintang sebelumnya
            $(this).addClass('rated');
            $(this).prevAll('.star').addClass('rated');
        });

        // Mencegah modal tertutup saat ada klik di dalamnya
        $(document).on('click', '.modal-content', function(event) {
            event.stopPropagation(); // Menghentikan penyebaran event
        });

        // Menutup modal saat ada klik di luar modal
        $(document).on('click', function(event) {
            if ($(event.target).closest('.modal').length === 0) {
                $('.modal').modal('hide'); // Menutup semua modals
            }
        });

        // Mencegah modal tertutup saat ada klik di luar modal
        $('.modal-dialog').on('click', function(event) {
            event.stopPropagation(); // Menghentikan penyebaran event
        });
    });
</script>
