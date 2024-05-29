<!-- Modal -->
<div class="modal fade" id="approveBorrowing_{{ $reqApprove->id }}" tabindex="-1" role="dialog"
    aria-labelledby="approveBorrowingLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered position-relative" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveBorrowingLabel">Approve Borrowing</h5>
                <button class="btn btn-link text-dark p-0" style="position: absolute; top:20px; right: 20px;"
                    data-bs-dismiss="modal">
                    <i class="fa fa-close" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('borrows.approve', $reqApprove->id) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <div class="modal-body container-fluid">
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input required autocomplete="off" type="date"
                                class="form-control @error('due_date') is-invalid @enderror"
                                id="due_date_{{ $reqApprove->id }}" due_date="name" value="{{ $reqApprove->due_date }}">
                            @error('due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-primary"
                            onclick="confirmApprove({{ $reqApprove->id }})">Approve</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
