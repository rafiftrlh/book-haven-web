 <form class="ms-2">
    <div class="form-group">
    <div class="mb-4">
        <label for="exampleFormControlInput1">Id Book</label>
        <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="Id Book" id="idInput">
    </div> 
    <div class="mb-4">
        <label for="exampleFormControlFile1" style="font-size: 13px;">Masukan Gambar Buku</label> <br>
        <input type="file" class="form-control-file" id="file_image" id="fileInput">
    </div>
    <div class="mb-4">
      <label for="exampleFormControlInput1">Title Book</label>
      <input type="Text" class="form-control" id="exampleFormControlInput1" placeholder="Title Book" id="titleInput">
    </div>
    <div class="mb-4">
      <label for="exampleFormControlInput1">Name Auotor</label>
      <input type="Text" class="form-control" id="exampleFormControlInput1" placeholder="Name Auotor" id="authorInput">
    </div>
    <div class="mb-4">
      <label for="exampleFormControlSelect1">Selecet Category</label>
      <select class="form-control" id="categorySelect">
        <option>Romance</option>
        <option>Comandy</option>
        <option>Advenfure</option>
      </select>
    </div>
    <div class="mb-4">
      <label for="exampleFormControlTextarea1">Writing Sinopsis</label>
      <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" id="synopsisInput"></textarea>
    </div>
    <div class="d-flex gap-3">
            <button type="button" id="submitBtn" class=" btn btn-primary">Submit</button>   
            <button type="button" class="btn btn-danger pl-2">Reset</button>
    </div>
</div>
  </form>


  