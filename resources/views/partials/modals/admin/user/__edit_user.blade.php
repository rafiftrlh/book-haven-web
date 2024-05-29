<!-- Modal -->
<div class="modal fade" id="editUser_{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editUserLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered position-relative" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edituserLabel">Edit user</h5>
                <button class="btn btn-link text-dark p-0" style="position: absolute; top:20px; right: 20px;"
                    data-bs-dismiss="modal">
                    <i class="fa fa-close" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    {{-- <input type="hidden" id="editUserId" value="{{ $user->id }}"> --}}
                    <div class="modal-body container-fluid">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input autocomplete="off" type="text" autofocus
                                class="form-control @error('username') is-invalid @enderror" id="username"
                                name="username" value="{{ $user->username }}">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label for="full_name" class="form-label">Full Name</label>
                            <input autocomplete="off" type="text"
                                class="form-control @error('full_name') is-invalid @enderror" id="full_name"
                                name="full_name" value="{{ $user->full_name }}">
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label for="email" class="form-label">Email</label>
                            <input autocomplete="off" type="email"
                                class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                value="{{ $user->email }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label for="role" class="form-label">Role</label>
                            <input autocomplete="off" type="number"
                                class="form-control @error('role') is-invalid @enderror" id="role" name="role"
                                value="{{ $user->role }}">
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
