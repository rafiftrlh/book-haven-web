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


    <div class="row row-cols-2 gap-2 justify-content-sm-between pt-3">
        @for ($i = 0; $i < 8; $i++)
            <a href="/detail/{{ $i + 1 }}" style="width: 190px" class="col card py-2 shadow-lg">
                <img src="assets/img/JUANDARA.jpg" style="border-radius: 10px; height: 180px; width: 150px;
                    margin-top: 1vw;" class="card-img-top ms-2" alt="...">
                <div class="card-body">
                    <h5 class="card-title text-dark">Juan Dara</h5>
                    <p class="card-text text-dark">By Cut Putri Khairan</p>
                    <p class="card-text text-dark">ID | 4.6</p>
                </div>
            </a>
        @endfor
    </div>
</div>
