<div class="container-fluid p-4">
    <a href="{{ route('admin.borrowings') }}" class="d-flex align-items-center gap-2 py-2 px-3 "
        style="width: fit-content; border: 1px solid gray; border-radius: 100px;">
        <svg style="rotate: -90deg" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                d="m6 10l10-8l10 8M16 2v28" />
        </svg>
        <span style="font-weight: 700; font-size: 12px;">Back</span>
    </a>
    <div class="mt-4">
        <input type="text" id="search" class="form-control"
            placeholder="Search approval request data by username...">
    </div>
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
                    url: "/api/borrowings/approve/" + borrowId,
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
                $.ajax({
                    url: "/api/borrowings/disapprove/" + borrowId,
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
        });
    }

    function updateReqTable(data) {
        var tableBody = $('#req-approve-table-body');
        tableBody.empty();
        if (data.length === 0) {
            tableBody.append(`
                <tr>
                    <td colspan="5">
                        <div class="card-body px-0 pt-0 pb-0">
                            <p class="h4 text-secondary" style="text-align: center">
                                No Request Approval Data
                            </p>
                        </div>
                    </td>
                </tr>
            `);
        } else {
            data.forEach(function(reqApproval) {
                var reqApprovalRow = `
                <tr>
                    <td>
                        <p class="text-xs text-secondary mb-0 px-3" style="text-transform: uppercase;">
                            ${reqApproval.id}</p>
                    </td>
                    <td>
                        <p class="text-xs text-secondary mb-0 px-3" style="text-transform: uppercase;">
                            ${reqApproval.books.book_code}</p>
                    </td>
                    <td>
                        <p class="text-xs text-secondary mb-0 px-3">
                            &commat;${reqApproval.users.username}</p>
                    </td>
                    <td>
                        <p class="text-xs text-secondary mb-0 px-3">${reqApproval.borrow_date}</p>
                    </td>
                    <td class="d-flex gap-3 px-3">
                        <button type="button" class="btn bg-gradient-info" data-bs-toggle="modal"
                            data-bs-target="#approveBorrowing_${reqApproval.id}"
                            data-book-id="${reqApproval.id}">Approve</button>

                            <div class="modal fade" id="approveBorrowing_${reqApproval.id}" tabindex="-1" role="dialog"
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
                                            <form action="" method="POST">
                                                @method('PATCH')
                                                @csrf
                                                <div class="modal-body container-fluid">
                                                    <div class="mb-3">
                                                        <label for="due_date" class="form-label">Due Date</label>
                                                        <input required autocomplete="off" type="date"
                                                            class="form-control @error('due_date') is-invalid @enderror"
                                                            id="due_date_${reqApproval.id}" due_date="name" value="${reqApproval.due_date}">
                                                        @error('due_date')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn bg-gradient-primary"
                                                        onclick="confirmApprove(${reqApproval.id})">Approve</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <button type="button" class="btn btn-danger"
                            onclick="confirmDisapprove(${reqApproval.id})">Disapprove</button>
                    </td>
                </tr>
                `;
                tableBody.append(reqApprovalRow);
            });
        }
    }

    document.getElementById('search').addEventListener('keyup', function() {
        let query = this.value;

        $.ajax({
            url: '{{ route('admin.searchReqApproval') }}',
            type: 'GET',
            data: {
                query: query
            },
            success: function(data) {
                updateReqTable(data);
            },
            error: function(error) {
                console.error(error); // Add this line to debug
            }
        });
    })
</script>
