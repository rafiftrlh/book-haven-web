<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\User;
use App\Models\UserReading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OfficerController extends Controller
{
    public function peminjaman(Request $request)
    {
        return view("roles.officer.index");
    }

    public function index()
    {
        $userCount = User::count();
        $bookCount = Book::count();
        $borrowingCount = Borrowing::count();
        $countReading = UserReading::count();
        
        return view('roles.officer.index', compact('userCount', 'bookCount', 'borrowingCount', 'countReading'));
    }

    public function users()
    {
        $users = User::all()->sortBy('role');
        
        return view('roles.officer.index', compact('users'));
    }

    public function filterByRole(Request $request)
    {
        $role = $request->role;

        if ($role == 0) {
            $users = User::orderBy('role')->get();
        } else {
            $users = User::where('role', $role)->get();
        }
        
        return response()->json($users);
    }

    public function searchUsers(Request $request)
    {
        $query = $request->input('query');
        $users = User::where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('username', 'LIKE', "%{$query}%")
                ->orWhere('full_name', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%");
        })->get();

        return response()->json($users);
    }

    public function categories()
    {
        $categories = Category::withTrashed()->orderBy('deleted_at')->get();
        
        return view('roles.officer.index', compact('categories'));
    }

    public function authors()
    {
        $authors = Author::withTrashed()->orderBy('deleted_at')->get();
        
        return view('roles.officer.index', compact('authors'));
    }

    public function books()
    {
        $books = Book::with('categories', 'authors')->get();
        $categories = Category::all();
        $authors = Author::all();

        $books->transform(function ($book) {
            $book->cover_url = $book->cover ? Storage::url($book->cover) : null;
            return $book;
        });

        return view('roles.officer.index', compact('books', 'categories', 'authors'));
    }

    public function createBook()
    {
        $categories = Category::all();
        $authors = Author::all();
        
        return view('roles.officer.index', compact('categories', 'authors'));
    }

    public function searchCategories(Request $request)
    {
        $query = $request->input('query');
        $categories = Category::withTrashed()->orderBy('deleted_at')->where('name', 'LIKE', "%{$query}%")->get();

        return response()->json($categories);
    }

    public function searchAuthors(Request $request)
    {
        $query = $request->input('query');
        $authors = Author::withTrashed()->orderBy('deleted_at')->where('name', 'LIKE', "%{$query}%")->get();

        return response()->json($authors);
    }

    public function searchBooks(Request $request)
    {
        $query = $request->input('query');
        $books = Book::with('categories', 'authors')->where('title_book', 'LIKE', "%{$query}%")->get();

        return response()->json($books);
    }
}
