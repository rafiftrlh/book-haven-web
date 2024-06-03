<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Borrowing Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Borrowing Report</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>User</th>
                <th>Book Code</th>
                <th>Status</th>
                <th>Fine</th>
            </tr>
        </thead>
        <tbody>
            {{-- @php
                $totalFine = 0;
            @endphp --}}
            @foreach ($reportBorrowings as $index => $r)
                {{-- @php
                    $fineAmount = 0;
                    if ($r->fines) {
                        foreach ($r->fines as $fine) {
                            if (in_array($fine->condition, ['broken', 'lost', 'late', 'late and broken'])) {
                                $fineAmount += $fine->price;
                            }
                        }
                    }
                    $totalFine += $fineAmount;
                @endphp --}}
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $r->borrow_date }}</td>
                    <td>{{ $r->users->full_name }}</td>
                    <td style="text-transform: uppercase;">{{ $r->books->book_code }}</td>
                    <td>{{ $r->status }}</td>
                    <td>
                        @if (in_array($r->status, ['broken', 'lost', 'late', 'late and broken']))
                            IDR. {{ $r->fines->price ?? 'N/A' }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" class="total">Total Fine</td>
                <td class="total">IDR. {{ $totalFine }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
