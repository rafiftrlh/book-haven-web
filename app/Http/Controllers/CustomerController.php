<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Bookmark;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
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
