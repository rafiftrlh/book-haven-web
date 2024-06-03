<div class="container-fluid p-4">
    <a href="{{ route('admin.borrowings') }}" class="d-flex align-items-center gap-2 py-2 px-3 "
        style="width: fit-content; border: 1px solid gray; border-radius: 100px;">
        <svg style="rotate: -90deg" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                d="m6 10l10-8l10 8M16 2v28" />
        </svg>
        <span style="font-weight: 700; font-size: 12px;">Back</span>
    </a>
    <div class="card mb-4 mt-4">
        <div class="card-header pb-0 d-flex gap-1">
            <h6>Being Borrowed</h6>
            <span class="text-primary" style="font-size: 14px; font-weight: 700; margin-right: 2px; margin-top: 2px;">
                @if ($totalBeingBorrowing > 99)
                    99+
                @else
                    {{ $totalBeingBorrowing }}
                @endif
            </span>
        </div>
        @if ($totalBeingBorrowing == 0)
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
                            @foreach ($beingBorrowings as $beingBorrowing)
                                <tr>
                                    <td>
                                        <p class="text-xs text-secondary mb-0 px-3" style="text-transform: uppercase;">
                                            {{ $beingBorrowing->id }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0 px-3" style="text-transform: uppercase;">
                                            {{ $beingBorrowing->books->book_code }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0 px-3">
                                            &commat;{{ $beingBorrowing->users->username }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0 px-3">{{ $beingBorrowing->due_date }}</p>
                                    </td>
                                    <td class="d-flex gap-3 px-3">
                                        <button type="button" class="btn bg-gradient-info"
                                            onclick="confirmReturn({{ $beingBorrowing->id }})">Return</button>
                                        <button type="button" class="btn bg-gradient-warning"
                                            onclick="confirmBroken({{ $beingBorrowing->id }})">Broken</button>
                                        <button type="button" class="btn bg-gradient-danger"
                                            onclick="confirmLost({{ $beingBorrowing->id }})">Lost</button>
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
    function confirmReturn(borrowId) {
        // Show SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure that he returned it in good condition?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, he returned it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/api/borrowings/return/" + borrowId,
                    type: 'PATCH',
                    data: {
                        _token: "{{ csrf_token() }}",
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

    function confirmBroken(borrowId) {
        // Show SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure he returned it in damaged condition?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "Yes, it's broken!",
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/api/borrowings/broken/" + borrowId,
                    type: 'PATCH',
                    data: {
                        _token: "{{ csrf_token() }}",
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

    function confirmLost(borrowId) {
        // Show SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure he lost it?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, he lost it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/api/borrowings/lost/" + borrowId,
                    type: 'PATCH',
                    data: {
                        _token: "{{ csrf_token() }}",
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
</script>
