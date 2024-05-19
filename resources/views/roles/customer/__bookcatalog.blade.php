{{-- content --}}

<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

<div class="container-fluid py-4">

    <div style="overflow-x: scroll; overflow-y: hidden; display: flex; gap: 5px;">
        @foreach ($categories as $category)
            <p style="text-transform: capitalize;"
                class="px-3 py-1 bg-primary border justify-content-center align-content-center text-white rounded">
                {{ $category }}
            </p>
        @endforeach
    </div>


    <div class="row row-cols-2 row-cols-md-2 row-cols-lg-4">
        @for ($i = 0; $i < 8; $i++)
            <div class="col mb-4">
                <div class="card" style="width: 100%;">
                    <div class="card-header">
                        <a href="/detailbuku" class="d-block text-center">
                            <img src="assets/img/JUANDARA.jpg" class="border-radius-lg img-fluid mx-auto d-block" style="max-width: 90%; height: auto;"> <!-- Memperbesar gambar dan menengahkan -->
                        </a>
                    </div>
                    <div class="card-body pt-2 text-left">
                        <a href="javascript:;" class="card-title h5 d-block text-darker">JuanDara</a>
                        <p class="card-description mb-2">By Cut Putri Khairan</p>
                        <p class="card-description mb-1">ID | 4.6</p> 
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>
