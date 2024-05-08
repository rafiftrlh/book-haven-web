<!-- Modal -->
<div class="modal fade" id="createUser" tabindex="-1" role="dialog" aria-labelledby="createUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserLabel">Buat User</h5>
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button" data-bs-dismiss="modal">
                    <i class="fa fa-close" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="modal-body container-fluid">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input autocomplete="off" type="username"
                                class="form-control @error('username') is-invalid @enderror" id="username"
                                name="username" value="{{ old('username') }}">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label for="full_name" class="form-label">Full name</label>
                            <input autocomplete="off" type="text"
                                class="form-control @error('full_name') is-invalid @enderror" id="full_name"
                                name="full_name" value="{{ old('full_name') }}">
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label for="password" class="form-label">Password</label>
                            <input autocomplete="off" type="password"
                                class="form-control @error('password') is-invalid @enderror" id="password"
                                name="password" value="{{ old('password') }}">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label for="email" class="form-label">Email</label>
                            <input autocomplete="off" type="email"
                                class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label for="role" class="form-label">Role</label>
                            <input autocomplete="off" type="number"
                                class="form-control @error('role') is-invalid @enderror" id="role" name="role"
                                value="{{ old('role') }}">
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-gradient-primary">Create User</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
