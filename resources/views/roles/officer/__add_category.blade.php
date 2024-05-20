<form class="ms-1">
    <p class="fs-5 mb-2 text-center text-dark" style="font-weight: bold;">Add Category</p>
    <div class="form-group">
        <div class="mb-4">
            <label for="exampleFormControlInput1">Name Category</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Name Category">
        </div>
        <div class="d-flex gap-3">
            <button type="button" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-danger pl-2">Reset</button>
        </div>
        <div class="card mb-4 mt-4">
            <div class="card-header pb-0">
                <h6>Data Category</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th
                                    class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                    Category</th>
                                <th
                                    class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody id="user-table-body">
                            <tr>
                                <td>
                                    <p class="text-xs text-secondary mb-0 px-3">
                                        Comedy
                                    </p>
                                </td>
                                <td class="d-flex gap-3 px-3">
                                    <button type="button" id="editButton" class="btn bg-gradient-info">Edit</button>
                                    <form action="">
                                        <button type="submit" id="deleteButton" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="text-xs text-secondary mb-0 px-3">
                                        Comedy
                                    </p>
                                </td>
                                <td class="d-flex gap-3 px-3">
                                    <button type="button" id="editButton" class="btn bg-gradient-info">Edit</button>
                                    <form action="">
                                        <button type="submit" id="deleteButton" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="text-xs text-secondary mb-0 px-3">
                                        Comedy
                                    </p>
                                </td>
                                <td class="d-flex gap-3 px-3">
                                    <button type="button" id="editButton" class="btn bg-gradient-info">Edit</button>
                                    <form action="">
                                        <button type="submit" id="deleteButton" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>

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
</script>
