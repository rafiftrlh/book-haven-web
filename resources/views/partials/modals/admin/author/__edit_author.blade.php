<!-- Modal -->
<div class="modal fade" id="editAuthor_{{ $author->id }}" tabindex="-1" role="dialog" aria-labelledby="editAuthorLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered position-relative" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAuthorLabel">Edit Author</h5>
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button position-absolute end-3 top-2"
                    data-bs-dismiss="modal">
                    <i class="fa fa-close" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('authors.update', $author->id) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <div class="modal-body container-fluid">
                        <div class="mb-3">
                            <label for="name" class="form-label">author</label>
                            <input required autocomplete="off" type="text"
                                class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                value="{{ $author->name }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-gradient-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
