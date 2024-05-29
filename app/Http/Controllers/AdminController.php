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

class AdminController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $bookCount = Book::count();
        $borrowingCount = Borrowing::count();
        $countReading = UserReading::count();
        return view('roles.admin.index', compact('userCount', 'bookCount', 'borrowingCount', 'countReading'));
    }

    public function users()
    {
        $users = User::all()->sortBy('role');
        $totalUser = $users->count();
        return view('roles.admin.index', compact('users', 'totalUser'));
    }

    public function filterByRole(Request $request)
    {
        $role = $request->role;
        if ($role == 0) {
            $users = User::orderBy('role')->get();
        } else {
            $users = User::where('role', $role)
                ->get();
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
        })
            ->get();

        return response()->json($users);
    }

    public function categories()
    {
        $categories = Category::withTrashed()->orderBy('deleted_at')->get();
        $totalCategory = $categories->count();

        return view('roles.admin.index', compact('categories', 'totalCategory'));
    }

    public function authors()
    {
        $authors = Author::withTrashed()->orderBy('deleted_at')->get();
        $totalAuthor = $authors->count();

        return view('roles.admin.index', compact('authors', 'totalAuthor'));
    }

    public function books()
    {
        $books = Book::with('categories', 'authors')->get();
        $categories = Category::all();
        $authors = Author::all();
        $totalBook = $books->count();

        $books->transform(function ($book) {
            if ($book->cover) {
                $book->cover_url = Storage::url($book->cover);
            } else {
                $book->cover_url = null;
            }
            return $book;
        });

        return view('roles.admin.index', compact('books', 'categories', 'authors', 'totalBook'));
    }

    public function borrowings()
    {
        $today = now()->toDateString();

        $reqApprovals = Borrowing::with('users', 'books')
            ->where('status', 'awaiting approval')
            ->limit(5)
            ->orderBy('borrow_date', 'asc')
            ->get();

        $totalReq = Borrowing::where('status', 'awaiting approval')
            ->count();

        $beingBorrowings = Borrowing::with('users', 'books')
            ->where('status', 'borrowed')
            ->where('due_date', '>=', $today)
            ->limit(5)
            ->orderBy('due_date', 'asc')
            ->get();

        $totalBeingBorrowing = Borrowing::where('status', 'borrowed')
            ->where('due_date', '>=', $today)
            ->count();

        return view('roles.admin.index', compact('reqApprovals', 'totalReq', 'beingBorrowings', 'totalBeingBorrowing'));
    }

    public function beingBorrowings()
    {
        $today = now()->toDateString();

        $beingBorrowings = Borrowing::with('users', 'books')
            ->where('status', 'borrowed')
            ->where('due_date', '>=', $today)
            ->orderBy('borrow_date', 'asc')
            ->get();

        $totalBeingBorrowing = Borrowing::where('status', 'borrowed')
            ->where('due_date', '>=', $today)
            ->count();

        return view('roles.admin.index', compact('beingBorrowings', 'totalBeingBorrowing'));
    }

    public function reqApprovals()
    {
        $today = now()->toDateString();

        $reqApprovals = Borrowing::with('users', 'books')
            ->where('status', 'awaiting approval')
            ->orderBy('borrow_date', 'asc')
            ->get();

        $totalReq = Borrowing::where('status', 'awaiting approval')
            ->count();

        return view('roles.admin.index', compact('reqApprovals', 'totalReq'));
    }

    public function createBook()
    {
        $categories = Category::all();
        $authors = Author::all();

        return view('roles.admin.index', compact('categories', 'authors'));
    }

    public function searchCategories(Request $request)
    {
        $query = $request->input('query');
        $categories = Category::withTrashed()->orderBy('deleted_at')->where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('name', 'LIKE', "%{$query}%");
        })
            ->get();

        return response()->json($categories);
    }

    public function searchAuthors(Request $request)
    {
        $query = $request->input('query');
        $authors = Author::withTrashed()->orderBy('deleted_at')->where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('name', 'LIKE', "%{$query}%");
        })
            ->get();

        return response()->json($authors);
    }

    public function searchBooks(Request $request)
    {
        $query = $request->input('query');
        $books = Book::with('categories', 'authors')->where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('title_book', 'LIKE', "%{$query}%");
        })
            ->get();

        return response()->json($books);
    }
}
