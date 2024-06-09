<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 "z href="{{ route('customer.profile') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24"
                style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                <path
                    d="M12 2C6.579 2 2 6.579 2 12s4.579 10 10 10 10-4.579 10-10S17.421 2 12 2zm0 5c1.727 0 3 1.272 3 3s-1.273 3-3 3c-1.726 0-3-1.272-3-3s1.274-3 3-3zm-5.106 9.772c.897-1.32 2.393-2.2 4.106-2.2h2c1.714 0 3.209.88 4.106 2.2C15.828 18.14 14.015 19 12 19s-3.828-.86-5.106-2.228z">
                </path>
            </svg>
            <span class="ms-1 font-weight-bold">Profile</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('home') ? 'active' : '' }}" href="{{ route('customer.home') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            style="fill: {{ request()->is('home') ? 'rgb(255, 255, 255)' : 'rgb(0, 0, 1)' }} ;transform: ;msFilter:;"
                            width="1em" height="1em" viewBox="0 0 24 24">
                            <path troke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 17v-5.548c0-.534 0-.801-.065-1.05a1.998 1.998 0 0 0-.28-.617c-.145-.213-.345-.39-.748-.741l-4.8-4.2c-.746-.653-1.12-.98-1.54-1.104c-.37-.11-.764-.11-1.135 0c-.42.124-.792.45-1.538 1.102L5.093 9.044c-.402.352-.603.528-.747.74a2 2 0 0 0-.281.618C4 10.65 4 10.918 4 11.452V17c0 .932 0 1.398.152 1.765a2 2 0 0 0 1.082 1.083C5.602 20 6.068 20 7 20s1.398 0 1.766-.152a2 2 0 0 0 1.082-1.083C10 18.398 10 17.932 10 17v-1a2 2 0 1 1 4 0v1c0 .932 0 1.398.152 1.765a2 2 0 0 0 1.082 1.083C15.602 20 16.068 20 17 20s1.398 0 1.766-.152a2 2 0 0 0 1.082-1.083C20 18.398 20 17.932 20 17" />
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">Home</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('book-catalog') ? 'active' : '' }}"
                    href="{{ route('customer.bookcatalog') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 256 256"
                            style="fill: {{ request()->is('book-catalog') ? 'rgb(255, 255, 255)' : 'rgb(0, 0, 1)' }} ;transform: ;msFilter:;">
                            <path
                                d="M216 32v160a8 8 0 0 1-8 8H72a16 16 0 0 0-16 16h136a8 8 0 0 1 0 16H48a8 8 0 0 1-8-8V56a32 32 0 0 1 32-32h136a8 8 0 0 1 8 8" />
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">Book Catalog</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('notification') ? 'active' : '' }}"
                    href="{{ route('customer.notification') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            style="fill: {{ request()->is('notification') ? 'rgb(255, 255, 255)' : 'rgb(0, 0, 1)' }} ;transform: ;msFilter:;"
                            viewBox="0 0 24 24">
                            <g fill="none">
                                <path
                                    d="M24 0v24H0V0zM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z" />
                                <path
                                    fill="{{ request()->is('notification') ? 'rgb(255, 255, 255)' : 'rgb(0, 0, 1)' }}"
                                    d="M12 2a7 7 0 0 0-7 7v3.528a1 1 0 0 1-.105.447l-1.717 3.433A1.1 1.1 0 0 0 4.162 18h15.676a1.1 1.1 0 0 0 .984-1.592l-1.716-3.433a1 1 0 0 1-.106-.447V9a7 7 0 0 0-7-7m0 19a3.001 3.001 0 0 1-2.83-2h5.66A3.001 3.001 0 0 1 12 21" />
                            </g>
                        </svg>
                    </div>
                    <div class="rounded-circle bg-primary" id="markNotif" hidden
                        style="width: 10px; height: 10px; top: -25px; left: 150px; position:relative;"></div>
                    <div>
                        <span class="nav-link-text ">Notification</span>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</aside>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Ketika dokumen siap, jalankan fungsi untuk mengambil notifikasi pengguna
        getAllNotifications();
    });

    function getAllNotifications() {
        // Mengirim permintaan AJAX untuk mendapatkan semua notifikasi pengguna
        $.ajax({
            url: "/get-notifications",
            type: "GET",
            dataType: "json",
            success: function(response) {
                // Menampilkan notifikasi ke dalam elemen HTML
                displayNotifications(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function displayNotifications(notifications) {
        if (notifications && notifications.length > 0) {
            // Tampilkan notifikasi dan hilangkan atribut hidden
            $("#markNotif").removeAttr('hidden');
        } else {
            // Sembunyikan notifikasi dengan menambahkan atribut hidden
            $("#markNotif").attr('hidden', true);
        }
    }
</script>
