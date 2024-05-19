<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

<!-- Container untuk kartu-kartu -->
<div class="container-fluid">
    <div class="py-4">
        <h4>Popular</h4>
        <div class="row row-cols-2 row-cols-md-2 row-cols-lg-4">
            @for ($i = 0; $i < 4; $i++)
                <div class="col mb-4">
                    <div class="card" style="width: 100%;">
                        <div class="card-header">
                            <a href="/detailbuku" class="d-block text-center"> 
                                <img src="assets/img/JUANDARA.jpg" class="border-radius-lg img-fluid mx-auto d-block" style="max-width: 90%; height: auto;">
                            </a>
                        </div>
                        <div class="card-body pt-2 text-left"> 
                            <a href="" class="card-title h5 d-block text-darker">JuanDara</a> 
                            <p class="card-description mb-2">By Cut Putri Khairan</p> 
                            <p class="card-description mb-1">ID | 4.6</p>
                        </div>
                    </div>
                </div>
            @endfor
        </div>

        <h4>
            New Book
        </h4>

        <div class="row row-cols-2 row-cols-md-2 row-cols-lg-4">
            @for ($i = 0; $i < 4; $i++)
                <div class="col mb-4">
                    <div class="card" style="width: 100%;">
                        <div class="card-header">
                            <a href="/detailbuku" class="d-block text-center"> 
                                <img src="assets/img/JUANDARA.jpg" class="border-radius-lg img-fluid mx-auto d-block" style="max-width: 90%; height: auto;">
                            </a>
                        </div>
                        <div class="card-body pt-2 text-left"> 
                            <a href="" class="card-title h5 d-block text-darker">JuanDara</a> 
                            <p class="card-description mb-2">By Cut Putri Khairan</p> 
                            <p class="card-description mb-1">ID | 4.6</p>
                        </div>
                    </div>
                </div>
            @endfor
        </div>



    </div>
</div>
