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
                            <div
                                class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md d-flex justify-content-center align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="20"
                                    viewBox="0 0 448 512" style="fill: rgb(255, 255, 255);transform: ;msFilter:;">
                                    <path
                                        d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0S96 57.3 96 128s57.3 128 128 128m89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4" />
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
                            <div
                                class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md d-flex justify-content-center align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                    viewBox="0 0 24 24">
                                    <path fill="white"
                                        d="M7 18h13a.75.75 0 0 1 .102 1.493L20 19.5H7a.75.75 0 0 1-.102-1.493zm10-3a.75.75 0 0 1 .102 1.493L17 16.5H4a.75.75 0 0 1-.102-1.493L4 15zm3-3a.75.75 0 0 1 .102 1.493L20 13.5H7a.75.75 0 0 1-.102-1.493L7 12zM6 5a2.75 2.75 0 0 1 2.55 1.717a.75.75 0 0 1-1.346.655l-.045-.091A1.25 1.25 0 1 0 6 9h11.5a.75.75 0 0 1 .102 1.493l-.102.007H6A2.75 2.75 0 0 1 6 5m14 1a.75.75 0 0 1 .102 1.493L20 7.5h-9a.75.75 0 0 1-.102-1.493L11 6z" />
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
    <div class="mt-3">
        <a href="{{ route('officer.exportPdf') }}" class="btn bg-gradient-primary" target="_blank">Download Report</a>
        <div class="card mb-4 mt-4">
            <div class="card-header pb-0 d-flex gap-1">
                <h6>Borrowing Data</h6>
                <span class="text-primary"
                    style="font-size: 14px; font-weight: 700; margin-right: 2px; margin-top: 2px;">
                    @if ($borrowingCount > 99)
                        99+
                    @else
                        {{ $borrowingCount }}
                    @endif
                </span>
            </div>
            @if ($borrowingCount == 0)
                <div class="card-body px-0 pt-0 pb-4">
                    <p class="h4 text-secondary" style="text-align: center">
                        No Borrowing Data
                    </p>
                </div>
            @else
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th
                                        class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                        Id
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                        Book Code
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                        Username
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                        Borrow Date
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                        Status
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs align-middle font-weight-bolder opacity-7">
                                        Fine
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="req-approve-table-body">
                                @foreach ($borrowings as $borrowing)
                                    <tr>
                                        <td>
                                            <p class="text-xs text-secondary mb-0 px-3"
                                                style="text-transform: uppercase;">
                                                {{ $borrowing->id }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0 px-3"
                                                style="text-transform: uppercase;">
                                                {{ $borrowing->books->book_code }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0 px-3">
                                                &commat;{{ $borrowing->users->username }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0 px-3">{{ $borrowing->borrow_date }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0 px-3">{{ $borrowing->status }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0 px-3">
                                                @if (in_array($borrowing->status, ['broken', 'lost', 'late', 'late and broken']))
                                                    IDR. {{ $borrowing->fines->price ?? 'N/A' }}
                                                @else
                                                    -
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5" class="total">
                                        <p style="font-weight: 600" class="text-dark mb-0 px-3">
                                            Total Fine
                                        </p>
                                    </td>
                                    <td class="total">
                                        <p style="font-weight: 600" class="text-dark mb-0 px-3">
                                            IDR. {{ $totalFine }}
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
    {{-- code diagram ditelatak --}}
    <div class="mt-4">
        <h6>Monthly Borrowing Data</h6>
        <canvas id="monthlyBorrowingChart"></canvas>
    </div>
</div>

 <!-- Include Chart.js -->
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <script>
     document.addEventListener('DOMContentLoaded', function() {
         fetch('/officer/monthly-borrowing-data')
             .then(response => response.json())
             .then(data => {
                 const ctx = document.getElementById('monthlyBorrowingChart').getContext('2d');

                 const months = data.map(entry => entry.month);
                 const counts = data.map(entry => entry.count);

                 new Chart(ctx, {
                     type: 'line',
                     data: {
                         labels: months,
                         datasets: [{
                             label: 'Number of Borrowers',
                             data: counts,
                             borderColor: 'rgba(75, 192, 192, 1)',
                             borderWidth: 2,
                             fill: false,
                             tension: 0.1
                         }]
                     },
                     options: {
                         scales: {
                             x: {
                                 title: {
                                     display: true,
                                     text: 'Month'
                                 }
                             },
                             y: {
                                 title: {
                                     display: true,
                                     text: 'Number of Borrowers'
                                 },
                                 beginAtZero: true
                             }
                         }
                     }
                 });
             });
     });
 </script>

