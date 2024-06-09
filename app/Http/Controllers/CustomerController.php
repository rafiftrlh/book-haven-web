<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\UserReading;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function index()
    {
        // Ambil semua buku baru
        $newBooks = Book::with('categories', 'authors', 'reviews')
            ->orderBy('created_at', 'desc')
            ->get();

        $newBooks->transform(function ($book) {
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

        // Ambil 5 buku paling populer
        $popularBooks = UserReading::select('book_id', DB::raw('COUNT(*) as total_readings'))
            ->groupBy('book_id')
            ->orderByDesc('total_readings')
            ->limit(5)
            ->get();

        // Ambil informasi detail buku untuk buku-buku populer
        $popularBooksDetails = [];
        foreach ($popularBooks as $popularBook) {
            $book = Book::with('categories', 'authors', 'reviews')->find($popularBook->book_id);
            $book->total_readings = $popularBook->total_readings;
            // Ubah cover URL jika cover tersedia
            if ($book->cover) {
                $book->cover_url = Storage::url($book->cover);
            } else {
                $book->cover_url = null;
            }
            // Hitung total rating
            $totalRating = $book->reviews->avg('rating');
            $book->total_rating = round($totalRating, 1);
            $book->authors_list = $book->authors->pluck('name')->implode(', ');
            $book->categories_list = $book->categories->pluck('name')->implode(', ');
            $popularBooksDetails[] = $book;
        }

        return view('roles.customer.index', compact('newBooks', 'popularBooksDetails'));
    }

    public function allBook()
    {
        $books = Book::with('categories', 'authors', 'reviews')->get();
        $categories = Category::all();

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

        return view('roles.customer.index', compact('books', 'categories'));
    }
}
