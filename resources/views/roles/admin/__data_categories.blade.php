<div class="container-fluid p-4">
    <div class="row">
        <div class="col-12">
            <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#createCategory">
                Create Category
            </button>
            @include('partials.modals.admin.category.__create_category')
            <br>
            <div class="btn-group btn-group-status mt-4" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary" id="btn-all"
                    onclick="filterCategories('all')">All</button>
                <button type="button" class="btn btn-secondary" id="btn-active"
                    onclick="filterCategories('active')">Active</button>
                <button type="button" class="btn btn-secondary" id="btn-deleted"
                    onclick="filterCategories('deleted')">Deleted</button>
            </div>
            <div class="mt-4">
                <input type="text" id="search" class="form-control" placeholder="Search categories...">
            </div>
            <div class="card mb-4 mt-4">
                <div class="card-header pb-0 d-flex gap-1">
                    <h6>Data Category</h6>
                    <span class="text-primary"
                        style="font-size: 14px; font-weight: 700; margin-right: 2px; margin-top: 2px;">
                        @if ($totalCategory > 99)
                            99+
                        @else
                            {{ $totalCategory }}
                        @endif
                    </span>
                </div>
                @if ($totalCategory == 0)
                    <div class="card-body px-0 pt-0 pb-4">
                        <p class="h4 text-secondary" style="text-align: center">
                            No Category Data
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
                                            Id</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                            Name</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody id="category-table-body">
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>
                                                <p class="text-xs text-secondary mb-0 px-3">{{ $category->id }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs text-secondary mb-0 px-3">{{ $category->name }}</p>
                                            </td>
                                            <td class="d-flex gap-3 px-3">
                                                @if ($category->deleted_at)
                                                    <button type="button" class="btn btn-success"
                                                        onclick="restoreCategory({{ $category->id }})">Restore</button>
                                                @else
                                                    <button type="button" class="btn bg-gradient-info"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editCategory_{{ $category->id }}"
                                                        data-book-id="{{ $category->id }}">Edit</button>
                                                    @include('partials.modals.admin.category.__edit_category')
                                                    <form action="{{ route('categories.destroy', $category->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                @endif
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
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function filterCategories(status) {
        $.ajax({
            url: '{{ route('categories.filterByDeletedStatus') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: status
            },
            success: function(data) {
                updateCategoryTable(data);

                // Menambahkan kelas "active" ke tombol yang sesuai
                $('.btn-group-status .btn').removeClass('btn-info');
                if (status === 'all') {
                    $('#btn-all').addClass('btn-info');
                } else if (status === 'deleted') {
                    $('#btn-deleted').addClass('btn-info');
                } else if (status === 'active') {
                    $('#btn-active').addClass('btn-info');
                }
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

    function restoreCategory(id) {
        $.ajax({
            url: '{{ url('/api/categories/restoreCategory') }}/' + id,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                alert(response.message);
                filterCategories('deleted'); // Refresh the deleted categories list
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

    function updateCategoryTable(data) {
        var tableBody = $('#category-table-body');
        tableBody.empty();
        data.forEach(function(category) {
            var statusText = category.deleted_at ? 'Deleted' : 'Active';
            var categoryRow = `
              <tr>
                  <td><p class="text-xs text-secondary mb-0 px-3">${category.id}</p></td>
                  <td><p class="text-xs text-secondary mb-0 px-3">${category.name}</p></td>
                  <td class="d-flex gap-3">
                      ${category.deleted_at ? `
                      <button type="button" class="btn btn-success" onclick="restoreCategory(${category.id})">Restore</button>
                      ` : `
                      <button type="button" class="btn bg-gradient-info" data-bs-toggle="modal" data-bs-target="#editCategory_${category.id}" data-book-id="${category.id}">Edit</button>
                      <!-- Modal -->
                      <div class="modal fade" id="editCategory_${category.id}" tabindex="-1" role="dialog"
                          aria-labelledby="editCategoryLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered position-relative" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="editCategoryLabel">Edit Category</h5>
                                      <button class="btn btn-link text-dark p-0 fixed-plugin-close-button position-absolute end-3 top-2"
                                          data-bs-dismiss="modal">
                                          <i class="fa fa-close" aria-hidden="true"></i>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                      <form action="/api/categories/${category.id}" method="POST">
                                          @method('PATCH')
                                          @csrf
                                          {{-- <input type="hidden" id="editUserId" value="${category.id}"> --}}
                                          <div class="modal-body container-fluid">
                                              <div class="mb-3">
                                                  <label for="name" class="form-label">Category</label>
                                                  <input required autocomplete="off" type="text"
                                                      class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                                      value="${category.name}">
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
                      <form action="/api/categories/${category.id}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger">Delete</button>
                      </form>
                      `}
                  </td>
              </tr>
          `;
            tableBody.append(categoryRow);
        });
    }

    $(document).ready(function() {
        $('#btn-all').addClass('btn-info');

        $('#search').on('keyup', function() {
            var query = $(this).val();
            $.ajax({
                url: '{{ route('admin.searchCategories') }}',
                type: 'GET',
                data: {
                    query: query
                },
                success: function(data) {
                    updateCategoryTable(data);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    });
</script>
