    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" /> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Or for RTL support -->
    {{-- <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" /> --}}
      
    <form class="ms-2 px-3" id="bookForm">
        <div class="form-group">
            <div class="mb-4">
                <label for="exampleFormControlInput1">Id Book</label>
                <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="Id Book"
                    id="idInput">
            </div>
            <div class="mb-4">
                <label for="exampleFormControlFile1" style="font-size: 13px;">Masukan Gambar Buku</label> <br>
                <input type="file" class="form-control-file" id="file_image" id="fileInput">
            </div>
            <div class="mb-4">
                <label for="exampleFormControlInput1">Title Book</label>
                <input type="Text" class="form-control" id="exampleFormControlInput1"  placeholder="Title Book"
                    id="titleInput">
            </div>
            <div class="mb-4">
                <label for="exampleFormControlInput1">Select Author</label>
                <select class="form-select" id="multiple-select-field-authors" id="SelectAuthor" data-placeholder="Select Author"
                    multiple>
                    <option>Christmas Island</option>
                    <option>South Sudan</option>
                    <option>Jamaica</option>
                    <option>Kenya</option>
                    <option>French Guiana</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="exampleFormControlInput1">Select Category</label>
                <select class="form-select" id="multiple-select-field-categories" data-placeholder="Select Category" id="SelectCategory"
                    multiple>
                    <option>Christmas Island</option>
                    <option>South Sudan</option>
                    <option>Jamaica</option>
                    <option>Kenya</option>
                    <option>French Guiana</option>
                </select>
            </div>


            <div class="mb-4">
                <label for="exampleFormControlTextarea1">Writing Sinopsis</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" id="synopsisInput"></textarea>
            </div>
            <div class="d-flex gap-3">
                <button type="button" id="submitBtn" class=" btn btn-primary">Submit</button>
                <button type="button" class="btn btn-danger pl-2" id="resetBtn">Reset</button>
            </div>
        </div>
    </form>

    <div class="card mb-4 mt-4 mx-3 ">
        <div class="card-header pb-0">
            <h6>Data User</h6>
        </div>
        <div class=" px-0 pt-0 pb-2" >
            <div class="table-responsive p-0 ">
                <table class="table align-items-center mb-0 ">
                    <thead>
                        <tr>
                            <th
                                class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                Book Code</th>
                            <th
                                class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                Cover</th>
                            <th
                                class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                Title</th>
                            <th
                                class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                Author</th>
                            <th
                                class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                Category</th>
                            <th
                                class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                Synopsis</th>
                            <th
                                class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody id="user-table-body" >
                        @for ($i = 0; $i < 10; $i++)
                            <tr>
                                <td>
                                    <p class="text-xs text-secondary mb-0 px-3">P00{{ $i }}</p>
                                </td>
                                <td>
                                    <img src="/assets/img/JUANDARA.jpg" alt="" style="width: 80px;">
                                </td>
                                <td>
                                    <p class="text-xs text-secondary mb-0 px-3">Juan Dara</p>
                                </td>
                                <td>
                                    <p class="text-xs text-secondary mb-0 px-3">
                                        Pa Owi
                                    </p>
                                </td>
                                <td>
                                    <p class="text-xs text-secondary mb-0 px-3" style=" white-space: normal;
                                    word-wrap: break-word;">
                                        Romance, Lorem, Ipsum, Dolor, Amet
                                    </p>
                                </td>
                                <td>
                                    <p class="text-xs text-secondary mb-0 px-3" style=" white-space: normal;
                                    word-wrap: break-word;">
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consectetur natus
                                        eveniet officia. Maiores reprehenderit quam perspiciatis. Nemo eius quisquam
                                        perspiciatis facere quidem asperiores earum veniam. Optio fuga reiciendis quo
                                        iusto.
                                    </p>
                                </td>
                                <td class="d-flex flex-column gap-3 px-3">
                                    <button type="button" class="btn bg-gradient-info" data-bs-toggle="modal"
                                        data-bs-target="#editUser_" data-book-id="">Edit</button>
                                    {{-- @include('partials.modals.admin.user.__edit_user') --}}
                                    <form action="" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>  
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <script>
        $('#multiple-select-field-categories').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });
        $('#multiple-select-field-authors').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });

      
        document.getElementById('resetBtn').addEventListener('click', function() {
        // Get the form element
        var form = document.getElementById('bookForm');

        // Reset the form fields
        form.reset();

        // Clear file input manually
        var fileInput = document.getElementById('fileInput');
        fileInput.value = '';

        // Clear select inputs
        var authorSelect = document.getElementById('SelectAuthor');
        var categorySelect = document.getElementById('SelectCategory');
        authorSelect.selectedIndex = -1;
        categorySelect.selectedIndex = -1;
    });

    </script>
