<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'book'])->get();
        return response()->json($borrowings);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
        ]);

        $userId = $request->user_id;
        $bookId = $request->book_id;

        // Cek apakah user memiliki permintaan peminjaman yang masih awaiting approval
        $pendingBorrowings = Borrowing::where('user_id', $userId)
            ->where('status', 'awaiting approval')
            ->count();

        if ($pendingBorrowings >= 2) {
            return response()->json([
                'status' => 'error',
                'message' => 'You have pending borrow requests.'
            ], 400);
        }

        // Cek jumlah buku yang sedang borrowed user dan belum returned
        $activeBorrowings = Borrowing::where('user_id', $userId)
            ->where('status', 'borrowed')
            ->count();

        if ($activeBorrowings >= 3) {
            return response()->json([
                'status' => 'error',
                'message' => 'You have reached the maximum number of borrowed books.'
            ], 400);
        }

        $borrowing = new Borrowing();
        $borrowing->user_id = $userId;
        $borrowing->book_id = $bookId;
        $borrowing->status = 'awaiting approval';
        $borrowing->changed_by = null;
        $borrowing->borrow_date = now();
        $borrowing->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Borrow request has been submitted.'
        ]);
    }

    // Approve a borrowing request
    public function approve(Request $request, $id)
    {
        $request->validate([
            'changed_by' => 'required|exists:users,id',
            'due_date' => 'required|date',
        ]);

        $borrowing = Borrowing::findOrFail($id);

        // Cek stok buku
        $book = Book::find($borrowing->book_id);
        if ($book->stock <= 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'This book is out of stock.'
            ], 400);
        }

        // Kurangi stok buku
        $book->stock -= 1;
        $book->save();

        // Update status peminjaman
        $borrowing->status = 'borrowed';
        $borrowing->changed_by = $request->changed_by;
        $borrowing->due_date = $request->due_date; // Menggunakan due_date dari request
        $borrowing->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Borrowing request has been approved.'
        ]);
    }

    public function disapprove(Request $request, $id)
    {
        $request->validate([
            'changed_by' => 'required|exists:users,id',
        ]);

        $borrowing = Borrowing::findOrFail($id);

        // Update status peminjaman menjadi ditolak
        $borrowing->status = 'disapprove';
        $borrowing->changed_by = $request->changed_by;
        $borrowing->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Borrowing request has been disapproved.'
        ]);
    }

    // Return a borrowed book
    public function returnBook($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->status = 'returned';
        $borrowing->return_date = now();
        $borrowing->save();

        return response()->json(['message' => 'Book returned successfully', 'borrowing' => $borrowing]);
    }


    public function broken($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->status = 'broken';
        $borrowing->return_date = now();
        $borrowing->save();

        $fine = new Fine();
        $fine->borrowing_id = $id;
        $fine->condition = 'broken';
        $fine->save();

        return response()->json(['message' => 'Book was returned but damaged', 'borrowing' => $borrowing]);
    }

    // Mark a borrowed book as lost
    public function lost($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->status = 'lost';
        $borrowing->save();

        $fine = new Fine();
        $fine->borrowing_id = $id;
        $fine->condition = 'lost';
        $fine->save();

        return response()->json(['message' => 'Book marked as lost', 'borrowing' => $borrowing]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrowing $borrowing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borrowing $borrowing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrowing $borrowing)
    {
        //
    }
}
