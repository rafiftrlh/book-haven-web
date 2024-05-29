<div class="container-fluid p-4">
    <!-- Request Approval Section -->
    <div class="card mb-4 mt-4">
        <div class="card-header pb-0 d-flex gap-1">
            <h6>Request Approval</h6>
            <span class="text-primary" style="font-size: 14px; font-weight: 700; margin-right: 2px; margin-top: 2px;">
                @if ($totalReq > 99)
                    99+
                @else
                    {{ $totalReq }}
                @endif
            </span>
        </div>
        @if ($totalReq == 0)
            <div class="card-body px-0 pt-0 pb-4">
                <p class="h4 text-secondary" style="text-align: center">
                    No Request Approval
                </p>
            </div>
        @else
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th
                                    class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                    Id
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                    Book Code
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                    Username
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                    Borrow Date
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody id="req-approve-table-body">
                            @foreach ($reqApprovals as $reqApprove)
                                <tr>
                                    <td>
                                        <p class="text-xs text-secondary mb-0 px-3" style="text-transform: uppercase;">
                                            {{ $reqApprove->id }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0 px-3" style="text-transform: uppercase;">
                                            {{ $reqApprove->books->book_code }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0 px-3">
                                            &commat;{{ $reqApprove->users->username }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0 px-3">{{ $reqApprove->borrow_date }}</p>
                                    </td>
                                    <td class="d-flex gap-3 px-3">
                                        <button type="button" class="btn bg-gradient-info" data-bs-toggle="modal"
                                            data-bs-target="#approveBorrowing_{{ $reqApprove->id }}" data-book-i
                                            d="{{ $reqApprove->id }}">Approve</button>
                                        @include('partials.modals.admin.borrowing.__approve_borrowing')
                                        <button type="button" class="btn btn-danger"
                                            onclick="confirmDisapprove({{ $reqApprove->id }})">Disapprove</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer pt-0">
                <a href="" class="ps-0 text-secondary icon-move-right pull-right fw-bold"
                    style="font-size: 14px">
                    More
                    <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                </a>
            </div>
        @endif
    </div>

    <!-- Being Borrowed Section -->
    <div class="card mb-4 mt-4">
        <div class="card-header pb-0 d-flex gap-1">
            <h6>Being Borrowed</h6>
            <span class="text-primary" style="font-size: 14px; font-weight: 700; margin-right: 2px; margin-top: 2px;">
                @if ($totalBeingBorrowed > 99)
                    99+
                @else
                    {{ $totalBeingBorrowed }}
                @endif
            </span>
        </div>
        @if ($totalBeingBorrowed == 0)
            <div class="card-body px-0 pt-0 pb-4">
                <p class="h4 text-secondary" style="text-align: center">
                    No Books Borrowed
                </p>
            </div>
        @else
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th
                                    class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                    Id
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                    Book Code
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                    Username
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                    Due Date
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody id="req-approve-table-body">
                            @foreach ($beingBorroweds as $beingBorrowed)
                                <tr>
                                    <td>
                                        <p class="text-xs text-secondary mb-0 px-3" style="text-transform: uppercase;">
                                            {{ $beingBorrowed->id }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0 px-3" style="text-transform: uppercase;">
                                            {{ $beingBorrowed->books->book_code }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0 px-3">
                                            &commat;{{ $beingBorrowed->users->username }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0 px-3">{{ $beingBorrowed->due_date }}</p>
                                    </td>
                                    <td class="d-flex gap-3 px-3">
                                        <button type="button" class="btn bg-gradient-info" data-bs-toggle="modal"
                                            data-bs-target="#editBeingBorrowed_{{ $beingBorrowed->id }}"
                                            data-beingBorrowed-id="{{ $beingBorrowed->id }}">Return</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer pt-0">
                <a href="" class="ps-0 text-secondary icon-move-right pull-right fw-bold"
                    style="font-size: 14px">
                    More
                    <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                </a>
            </div>
        @endif
    </div>
</div>

<script>
    function confirmApprove(borrowId) {
        Swal.fire({
            title: 'Are you sure you want to approve this borrowing request?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, approve it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Ambil nilai due_date dari input
                var dueDate = document.getElementById('due_date_' + borrowId).value;

                // Make AJAX call to check for borrowing conditions and submit the form if conditions are met
                $.ajax({
                    url: "api/borrowings/approve/" + borrowId,
                    type: 'PATCH',
                    data: {
                        _token: "{{ csrf_token() }}",
                        changed_by: "{{ Auth::user()->id }}",
                        due_date: dueDate // Gunakan nilai due_date dari input
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
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
                            title: 'Error!',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    }

    function confirmDisapprove(borrowId) {
        // Show SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure you want to disapprove this borrowing request?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, disapprove it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Perform the disapproval action
                disapproveBorrow(borrowId);
            }
        });
    }

    function disapproveBorrow(borrowId) {
        $.ajax({
            url: "api/borrowings/disapprove/" + borrowId,
            type: 'PATCH',
            data: {
                _token: "{{ csrf_token() }}",
                changed_by: "{{ Auth::user()->id }}"
            },
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
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
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    }
</script>
