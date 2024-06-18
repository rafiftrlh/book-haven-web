<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $borrowedBooks = Borrowing::with('books')
            ->where('user_id', $user->id)
            ->whereNull('return_date')
            ->get();


        return view('roles.customer.index', compact('user', 'borrowedBooks'));
    }

    public function showBorrowedBooksPage()
    {
        $user = Auth::user();
        $borrowedBooks = Borrowing::with('book')
            ->where('user_id', $user->id)
            ->whereNull('return_date')
            ->get();

        return view('roles.customer.index', compact('borrowedBooks'));
    }

    public function showHistoryBorrowed()
    {
        $user = Auth::user();
        $borrowingHistory = Borrowing::with('books')
            ->where('user_id', $user->id)
            ->whereNotNull('return_date')
            ->get();

        return view('roles.customer.index', compact('borrowingHistory'));
    }

    public function showBookmarkedBooks()
    {
        $user = Auth::user();
        $books = $user->bookmarks()->with('categories', 'authors')->get();

        $books->transform(function ($book) {
            if ($book->cover) {
                $book->cover_url = Storage::url($book->cover);
            } else {
                $book->cover_url = null;
            }
            $book->authors_list = $book->authors->pluck('name')->implode(', ');
            $book->categories_list = $book->categories->pluck('name')->implode(', ');

            // Hitung total rating
            $totalRating = $book->reviews->avg('rating');
            $book->total_rating = round($totalRating, 1);

            return $book;
        });

        return view('roles.customer.index', compact('books'));
    }

}
