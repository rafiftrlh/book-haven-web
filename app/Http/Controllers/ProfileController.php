<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $borrowedBooks = Borrowing::with('books')
            ->where('user_id', $user->id)
            ->whereNull('return_date')
            ->get();
        $borrowingHistory = Borrowing::with('books')
            ->where('user_id', $user->id)
            ->whereNotNull('return_date')
            ->get();

        return view('roles.customer.index', compact('user', 'borrowedBooks', 'borrowingHistory'));
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

    public function showProfile()
    {
        $user = Auth::user();
        $borrowedBooks = Borrowing::with('book')
            ->where('user_id', $user->id)
            ->get();

        return view('profile', compact('user', 'borrowedBooks'));
    }
}
