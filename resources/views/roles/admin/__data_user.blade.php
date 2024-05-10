    {{-- content --}}

    <div class="container-fluid py-4">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal"
                        data-bs-target="#createUser">
                        Create User
                    </button>
                    @include('partials.user.__create_user')
                    <div class="card mb-4">

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
                                                Nama</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                                Kelas</th>
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
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>
                                                    <p class="text-xs text-secondary mb-0 px-3">{{ $user->username }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-xs text-secondary mb-0 px-3">{{ $user->full_name }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-xs text-secondary mb-0" px-3>{{ $user->email }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs text-secondary mb-0" px-3>
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
                                                        data-book-id="{{ $user->id }}">
                                                        Edit
                                                    </button>
                                                    {{-- @include('partials.modals.edit_siswa') --}}
                                                    <form action="{{ route('users.destroy', $user->id) }}"
                                                        method="POST">
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
    </div>
