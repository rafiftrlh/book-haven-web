<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\Notification;
use App\Models\UserReading;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'book'])->get();
        return $borrowings;
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

        // Cek jumlah buku yang sedang dipinjam
        $activeBorrowings = Borrowing::where('user_id', $userId)
            ->where('status', 'borrowed')
            ->count();

        $pendingAndActiveBorrowings = $pendingBorrowings + $activeBorrowings;

        if ($pendingAndActiveBorrowings >= 3) {
            return response()->json([
                'status' => 'error',
                'message' => 'You have ' . $pendingBorrowings . ' pending borrow request and are borrowing ' . $activeBorrowings . ' books. The limit for borrowing or requesting approval is 3 times.'
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

        // Update status peminjaman
        $borrowing->status = 'borrowed';
        $borrowing->changed_by = $request->changed_by;
        $borrowing->due_date = $request->due_date; // Menggunakan due_date dari request
        $borrowing->save();

        $notification = new Notification();
        $notification->user_id = $borrowing->user_id;
        $notification->message = 'The book with the title ' . $book->title_book . ' can be picked up at the library and the loan deadline is ' . $request->due_date;
        $notification->status = 'Unread';
        $notification->notification_type = 'Retrieval of books that have been approved';
        $notification->save();

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

        $book = Book::find($borrowing->book_id);

        $notification = new Notification();
        $notification->user_id = $borrowing->user_id;
        $notification->message = 'The book with the title ' . $book->title_book . ' is not approved.';
        $notification->status = 'Unread';
        $notification->notification_type = 'Unapproved borrowing';
        $notification->save();

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

        $user_reading = new UserReading();
        $user_reading->user_id = $borrowing->user_id;
        $user_reading->book_id = $borrowing->book_id;
        $user_reading->save();

        $book = Book::find($borrowing->book_id);

        $notification = new Notification();
        $notification->user_id = $borrowing->user_id;
        $notification->message = 'You have returned the book with the title ' . $book->title_book;
        $notification->status = 'Unread';
        $notification->notification_type = 'Unapproved borrowing';
        $notification->save();

        return response()->json(['message' => 'Book returned successfully', 'borrowing' => $borrowing]);
    }

    public function broken($id)
    {
        $borrowing = Borrowing::with('books')->findOrFail($id);
        $borrowing->status = 'broken';
        $borrowing->return_date = now();
        $borrowing->save();

        $user_reading = new UserReading();
        $user_reading->user_id = $borrowing->user_id;
        $user_reading->book_id = $borrowing->book_id;
        $user_reading->save();

        $fine = new Fine();
        $fine->borrowing_id = $id;
        $fine->condition = 'broken';
        $fine->type = 'pay half price';
        $fine->price = $borrowing->books->price / 2;
        $fine->save();

        $book = Book::find($borrowing->book_id);

        $notification = new Notification();
        $notification->user_id = $borrowing->user_id;
        $notification->message = 'You have returned a book with the title ' . $book->title_book . 'in damaged condition, you must pay a fine of' . ($borrowing->books->price / 2);
        $notification->status = 'Unread';
        $notification->notification_type = 'Returning a book but in a damaged condition';
        $notification->save();

        return response()->json(['message' => 'Book was returned but damaged', 'borrowing' => $borrowing]);
    }

    // Mark a borrowed book as lost
    public function lost($id)
    {
        $borrowing = Borrowing::with('books')->findOrFail($id);
        $borrowing->status = 'lost';
        $borrowing->return_date = now();
        $borrowing->save();

        $fine = new Fine();
        $fine->borrowing_id = $id;
        $fine->condition = 'lost';
        $fine->type = 'pay full price';
        $fine->price = $borrowing->books->price;
        $fine->save();

        $book = Book::find($borrowing->book_id);

        $notification = new Notification();
        $notification->user_id = $borrowing->user_id;
        $notification->message = 'You have lost a book with the title ' . $book->title_book . ', you must pay a fine of' . $borrowing->books->price;
        $notification->status = 'Unread';
        $notification->notification_type = 'Omitting a book';
        $notification->save();

        return response()->json(['message' => 'Book marked as lost', 'borrowing' => $borrowing]);
    }

    public function late($id)
    {
        $borrowing = Borrowing::with('books')->findOrFail($id);
        $borrowing->status = 'late';
        $borrowing->return_date = now();
        $borrowing->save();

        // Hitung jumlah hari terlambat
        $daysLate = Carbon::parse($borrowing->due_date)->diffInDays(Carbon::now(), false);

        // Hitung denda
        $price = max($daysLate * 10000, 0);

        $fine = new Fine();
        $fine->borrowing_id = $id;
        $fine->condition = 'late';
        $fine->type = 'pay late per day';
        $fine->price = $price;
        $fine->save();

        $book = Book::find($borrowing->book_id);

        $notification = new Notification();
        $notification->user_id = $borrowing->user_id;
        $notification->message = 'You returned a book with the title ' . $book->title_book . ' late, you must pay a fine of' . $borrowing->books->price;
        $notification->status = 'Unread';
        $notification->notification_type = 'Returned late';
        $notification->save();

        return response()->json(['message' => 'Book returned late', 'borrowing' => $borrowing]);
    }

    public function lateAndBroken($id)
    {
        $borrowing = Borrowing::with('books')->findOrFail($id);
        $borrowing->status = 'late and broken';
        $borrowing->return_date = now();
        $borrowing->save();

        // Hitung jumlah hari terlambat
        $daysLate = Carbon::parse($borrowing->due_date)->diffInDays(Carbon::now(), false);

        // Hitung denda keterlambatan
        $lateFine = max($daysLate * 10000, 0);

        // Hitung denda buku rusak
        $brokenFine = $borrowing->books->price / 2;

        // Total denda
        $totalFine = $lateFine + $brokenFine;

        // Simpan informasi denda
        $fine = new Fine();
        $fine->borrowing_id = $id;
        $fine->condition = 'late and broken';
        $fine->type = 'fine late and damaged';
        $fine->price = $totalFine;
        $fine->save();

        $book = Book::find($borrowing->book_id);

        // Simpan notifikasi untuk pengguna
        $notification = new Notification();
        $notification->user_id = $borrowing->user_id;
        $notification->message = 'You returned a book with the title ' . $book->title_book . ' late and in damaged condition. You must pay a fine of ' . $totalFine;
        $notification->status = 'Unread';
        $notification->notification_type = 'Returned late and damaged';
        $notification->save();

        return response()->json(['message' => 'Book returned late and damaged', 'borrowing' => $borrowing]);
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
