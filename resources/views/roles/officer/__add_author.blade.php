<form class="ms-1" id="addauthor">
    <p class="fs-5 mb-2 text-center text-dark" style="font-weight: bold;">Add Author</p>
    <div class="form-group">
        <div class="mb-4">
            <label for="exampleFormControlInput1">Name Author</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Name Author">
        </div>
        <div class="d-flex gap-3">
            <button type="button" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-danger pl-2" id="resetBtn">Reset</button>
        </div>
    </div>
</form>
<div class="card mb-4 mt-4">
    <div class="card-header pb-0">
        <h6>Data Author</h6>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
            <table class="table align-items-center">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                            Name Author</th>
                        <th class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                            Action</th>
                    </tr>
                </thead>
                <tbody id="user-table-body">
                    @for ($i = 0; $i < 5; $i++)
                        <tr>
                            <td>
                                <p class="text-xs text-secondary mb-0 px-3">
                                    ari ganteng
                                </p>
                            </td>
                            <td class="d-flex gap-3 px-3">
                                <button type="button" id="editButton" class="btn bg-gradient-info">Edit</button>

                                <button type="submit" id="deleteButton" class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function handleEditButtonClick() {
        var confirmation = prompt("Masukan perubahan", "");
        if (confirmation) {
            alert("Data berhasil di edit");
        } else {
            alert("Anda membatalkan edit.");
        }
    }

    function handleDeleteButtonClick() {

        var confirmation = confirm("Apakah Anda yakin ingin menghapus?");
        if (confirmation) {
            alert("Anda telah menghapus data.");
        } else {
            alert("Anda membatalkan penghapusan.");
        }
    }

    document
    document.getElementById("editButton").addEventListener("click", handleEditButtonClick);


    document.getElementById("deleteButton").addEventListener("click", handleDeleteButtonClick);

    document.getElementById('resetBtn').addEventListener('click', function() {
        document.getElementById('addauthor').reset();
    });
</script>
