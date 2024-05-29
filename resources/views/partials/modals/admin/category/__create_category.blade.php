<!-- Modal -->
<div class="modal fade" id="createCategory" tabindex="-1" role="dialog" aria-labelledby="createCategoryLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCategoryLabel">Create Category</h5>
                <button class="btn btn-link text-dark p-0" style="position: absolute; top:20px; right: 20px;"
                    data-bs-dismiss="modal">
                    <i class="fa fa-close" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-body container-fluid">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category</label>
                            <input required autocomplete="off" type="text"
                                class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-gradient-primary">Create Category</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
