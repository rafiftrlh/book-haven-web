    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#createUser">
                    Create User
                </button>
                @include('partials.modals.admin.user.__create_user')
                <br>
                <div class="mt-2 btn-group-role" role="group">
                    <button id="btn-all" type="button" class="btn btn-secondary "
                        onclick="filterUsers(0)">All</button>
                    <button id="btn-admin" type="button" class="btn btn-secondary "
                        onclick="filterUsers(1)">Admin</button>
                    <button id="btn-officer" type="button" class="btn btn-secondary "
                        onclick="filterUsers(2)">Officer</button>
                    <button id="btn-customer" type="button" class="btn btn-secondary "
                        onclick="filterUsers(3)">Customer</button>
                </div>
                <div class="mt-4">
                    <input type="text" id="search" class="form-control" placeholder="Search users...">
                </div>
                <div class="card mb-4 mt-4">
                    <div class="card-header pb-0">
                        <h6>Data User</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                            Username</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                            Full Name</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                            Email</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                            Role</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody id="user-table-body">
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                <p class="text-xs text-secondary mb-0 px-3">{{ $user->username }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs text-secondary mb-0 px-3">{{ $user->full_name }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs text-secondary mb-0 px-3">{{ $user->email }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs text-secondary mb-0 px-3">
                                                    @if ($user->role == 1)
                                                        Admin
                                                    @elseif ($user->role == 2)
                                                        Officer
                                                    @else
                                                        Customer
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="d-flex gap-3 px-3">
                                                <button type="button" class="btn bg-gradient-info"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editUser_{{ $user->id }}"
                                                    data-book-id="{{ $user->id }}">Edit</button>
                                                @include('partials.modals.admin.user.__edit_user')
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function filterUsers(role) {
            $.ajax({
                url: '{{ route('admin.filterByRole') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    role: role
                },
                success: function(data) {
                    updateTable(data);

                    // Menambahkan kelas "active" ke tombol yang sesuai
                    $('.btn-group-role .btn').removeClass('btn-info');
                    if (role == 0) {
                        $('#btn-all').addClass('btn-info');
                    } else if (role == 1) {
                        $('#btn-admin').addClass('btn-info');
                    } else if (role == 2) {
                        $('#btn-officer').addClass('btn-info');
                    } else if (role == 3) {
                        $('#btn-customer').addClass('btn-info');
                    }
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }

        function updateTable(data) {
            var tableBody = $('#user-table-body');
            tableBody.empty();
            data.forEach(function(user) {
                var roleText = (user.role == 1) ? 'Admin' : (user.role == 2) ? 'Officer' : 'Customer';
                var userRow = `
                <tr>
                    <td><p class="text-xs text-secondary mb-0 px-3">${user.username}</p></td>
                    <td><p class="text-xs text-secondary mb-0 px-3">${user.full_name}</p></td>
                    <td><p class="text-xs text-secondary mb-0 px-3">${user.email}</p></td>
                    <td><p class="text-xs text-secondary mb-0 px-3">${roleText}</p></td>
                    <td class="d-flex gap-3 px-3">
                        <button type="button" class="btn bg-gradient-info" data-bs-toggle="modal" data-bs-target="#editUser_${user.id}" data-book-id="${user.id}">Edit</button>
                        <!-- Modal -->
                        <div class="modal fade" id="editUser_${user.id}" tabindex="-1" role="dialog" aria-labelledby="editUserLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered position-relative" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="edituserLabel">Edit user</h5>
                                        <button class="btn btn-link text-dark p-0 fixed-plugin-close-button position-absolute end-3 top-2"
                                            data-bs-dismiss="modal">
                                            <i class="fa fa-close" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/api/users/${user.id}" method="POST">
                                            @method('PATCH')
                                            @csrf
                                            {{-- <input type="hidden" id="editUserId" value="${user.id}"> --}}
                                            <div class="modal-body container-fluid">
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Username</label>
                                                    <input autocomplete="off" type="text" autofocus
                                                        class="form-control @error('username') is-invalid @enderror" id="username"
                                                        name="username" value="${user.username}">
                                                    @error('username')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror

                                                    <label for="full_name" class="form-label">Full Name</label>
                                                    <input autocomplete="off" type="text"
                                                        class="form-control @error('full_name') is-invalid @enderror" id="full_name"
                                                        name="full_name" value="${user.full_name}">
                                                    @error('full_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror

                                                    <label for="email" class="form-label">Email</label>
                                                    <input autocomplete="off" type="email"
                                                        class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                                        value="${user.email}">
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror

                                                    <label for="role" class="form-label">Role</label>
                                                    <input autocomplete="off" type="number"
                                                        class="form-control @error('role') is-invalid @enderror" id="role" name="role"
                                                        value="${user.role}">
                                                    @error('role')
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
                        <form action="/api/users/${user.id}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            `;
                tableBody.append(userRow);
            });
        }

        $(document).ready(function() {
            $('#btn-all').addClass('btn-info');

            $('#search').on('keyup', function() {
                var query = $(this).val();
                $.ajax({
                    url: '{{ route('admin.searchUsers') }}',
                    type: 'GET',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        updateTable(data);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
