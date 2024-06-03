<div class="container-fluid p-4">
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Users</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $userCount }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md d-flex justify-content-center align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="20" viewBox="0 0 448 512" style="fill: rgb(255, 255, 255);transform: ;msFilter:;">
                                    <path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0S96 57.3 96 128s57.3 128 128 128m89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Books</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $bookCount }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Readings</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $countReading }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md d-flex justify-content-center align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                    <path fill="white" d="M7 18h13a.75.75 0 0 1 .102 1.493L20 19.5H7a.75.75 0 0 1-.102-1.493zm10-3a.75.75 0 0 1 .102 1.493L17 16.5H4a.75.75 0 0 1-.102-1.493L4 15zm3-3a.75.75 0 0 1 .102 1.493L20 13.5H7a.75.75 0 0 1-.102-1.493L7 12zM6 5a2.75 2.75 0 0 1 2.55 1.717a.75.75 0 0 1-1.346.655l-.045-.091A1.25 1.25 0 1 0 6 9h11.5a.75.75 0 0 1 .102 1.493l-.102.007H6A2.75 2.75 0 0 1 6 5m14 1a.75.75 0 0 1 .102 1.493L20 7.5h-9a.75.75 0 0 1-.102-1.493L11 6z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Borrowing</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $borrowingCount }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
