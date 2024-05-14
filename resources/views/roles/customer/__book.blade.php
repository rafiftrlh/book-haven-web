 {{-- content --}}

 <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">


 <!-- Tambahkan card di sini -->
 <div class="container-fluid py-4">
     <div class="py-4">
         <h4>
             Porpular
         </h4>
         <div class="row row-cols-2 gap-2 justify-content-sm-between">
             @for ($i = 0; $i < 4; $i++)
                 <div style="width: 190px" class="col card py-2 shadow-lg">
                     <img src="assets/img/JUANDARA.jpg"
                         style="border-radius: 10px; height: 180px; width: 150px;
                     margin-top: 1vw;"
                         class="card-img-top ms-2" alt="...">
                     <div class="card-body">
                         <h5 class="card-title text-dark">Juan Dara</h5>
                         <p class="card-text text-dark">By Cut Putri Khairan</p>
                         <p class="card-text text-dark">ID | 4.6</p>
                     </div>
                 </div>
             @endfor
         </div>
         <h4 class="pt-3">
             New Book
         </h4>
         <div class="row row-cols-2 gap-2 justify-content-sm-between pt-4">
             @for ($i = 0; $i < 8; $i++)
                 <div style="width: 190px" class="col card py-2 shadow-lg">
                     <img src="assets/img/JUANDARA.jpg"
                         style="border-radius: 10px; height: 180px; width: 150px;
                    margin-top: 1vw;"
                         class="card-img-top ms-2" alt="...">
                     <div class="card-body">
                         <h5 class="card-title text-dark">Juan Dara</h5>
                         <p class="card-text text-dark">By Cut Putri Khairan</p>
                         <p class="card-text text-dark">ID | 4.6</p>
                     </div>
                 </div>
             @endfor
         </div>








         <!-- Tambahkan card lainnya di sini -->
     </div>
 </div>
 </div>
