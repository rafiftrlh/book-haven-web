<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Fine;
use App\Models\User;
use App\Models\UserReading;
use \Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $bookCount = Book::count();
        $borrowingCount = Borrowing::count();
        $countReading = UserReading::count();

        $borrowings = Borrowing::all();

        $totalFine = Fine::sum('price');

        return view('roles.admin.index', compact('userCount', 'bookCount', 'borrowingCount', 'countReading', 'borrowings', 'totalFine'));
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

        // Request approvals
        $reqApprovals = Borrowing::with('users', 'books')
            ->where('status', 'awaiting approval')
            ->limit(5)
            ->get();

        $totalReq = Borrowing::where('status', 'awaiting approval')->count();

        // Being borrowings
        $beingBorrowings = Borrowing::with('users', 'books')
            ->where('status', 'borrowed')
            ->where('due_date', '>=', $today)
            ->limit(5)
            ->get();

        $totalBeingBorrowing = Borrowing::where('status', 'borrowed')
            ->where('due_date', '>=', $today)
            ->count();

        // Late returneds
        $lateReturneds = Borrowing::with('users', 'books')
            ->where('status', 'borrowed')
            ->where('due_date', '<', $today)
            ->limit(5)
            ->orderBy('due_date', 'asc')
            ->get();

        // Calculate fines for late returneds
        foreach ($lateReturneds as $lateReturned) {
            $daysLate = Carbon::parse($lateReturned->due_date)->diffInDays(Carbon::now(), false);
            $lateFine = max($daysLate * 10000, 0); // Calculate late fine
            $lateReturned->fine_price = $lateFine; // Add fine price to the borrowing data
        }

        $totalLateReturned = Borrowing::where('status', 'borrowed')
            ->where('due_date', '<', $today)
            ->count();

        return view(
            'roles.admin.index',
            compact(
                'reqApprovals',
                'totalReq',
                'beingBorrowings',
                'totalBeingBorrowing',
                'lateReturneds',
                'totalLateReturned'
            )
        );
    }

    public function fines()
    {
        // Mengambil data denda berdasarkan kategori late, broken, dan lost
        $lateFines = Fine::with('borrowing.books', 'borrowing.users')
            ->where('condition', 'late')
            ->limit(5)
            ->get();

        $brokenFines = Fine::with('borrowing.books', 'borrowing.users')
            ->where('condition', 'broken')
            ->limit(5)
            ->get();

        $lostFines = Fine::with('borrowing.books', 'borrowing.users')
            ->where('condition', 'lost')
            ->limit(5)
            ->get();

        $lateAndBrokenFines = Fine::with('borrowing.books', 'borrowing.users')
            ->where('condition', 'late and broken')
            ->limit(5)
            ->get();

        // Menghitung total denda untuk setiap kategori
        $totalLateFine = Fine::where('condition', 'late')->count();
        $totalBrokenFine = Fine::where('condition', 'broken')->count();
        $totalLostFine = Fine::where('condition', 'lost')->count();
        $totalLateAndBrokenFine = Fine::where('condition', 'late and broken')->count();

        return view('roles.admin.index', compact('lateFines', 'brokenFines', 'lostFines', 'lateAndBrokenFines', 'totalLateFine', 'totalBrokenFine', 'totalLostFine', 'totalLateAndBrokenFine'));
    }

    public function allLateFines()
    {
        // Mengambil semua data denda dengan kondisi 'late'
        $lateFines = Fine::with('borrowing.books', 'borrowing.users')
            ->where('condition', 'late')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalLateFine = Fine::where('condition', 'late')->count();


        return view('roles.admin.index', compact('lateFines', 'totalLateFine'));
    }

    public function allBrokenFines()
    {
        // Mengambil semua data denda dengan kondisi 'broken'
        $brokenFines = Fine::with('borrowing.books', 'borrowing.users')
            ->where('condition', 'broken')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalBrokenFine = Fine::where('condition', 'broken')->count();

        return view('roles.admin.index', compact('brokenFines', 'totalBrokenFine'));
    }

    public function allLostFines()
    {
        // Mengambil semua data denda dengan kondisi 'lost'
        $lostFines = Fine::with('borrowing.books', 'borrowing.users')
            ->where('condition', 'lost')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalLostFine = Fine::where('condition', 'lost')->count();

        return view('roles.admin.index', compact('lostFines', 'totalLostFine'));
    }

    public function allLateAndBrokenFines()
    {
        $lateAndBrokenFines = Fine::with('borrowing.books', 'borrowing.users')
            ->where('condition', 'late and broken')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalLateAndBrokenFine = Fine::where('condition', 'late and broken')->count();

        return view('roles.admin.index', compact('lateAndBrokenFines', 'totalLateAndBrokenFine'));
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

    public function lateReturned()
    {
        $today = now()->toDateString();

        $lateReturneds = Borrowing::with('users', 'books')
            ->where('status', 'borrowed')
            ->where('due_date', '<', $today)
            ->orderBy('borrow_date', 'desc')
            ->get();

        // Loop through each borrowing to calculate the fine
        foreach ($lateReturneds as $lateReturned) {
            $daysLate = Carbon::parse($lateReturned->due_date)->diffInDays(Carbon::now(), false);
            $lateFine = max($daysLate * 10000, 0); // Calculate late fine
            $lateReturned->fine_price = $lateFine; // Add fine price to the borrowing data
        }

        $totalLateReturned = Borrowing::where('status', 'borrowed')
            ->where('due_date', '<', $today)
            ->count();

        return view('roles.admin.index', compact('lateReturneds', 'totalLateReturned'));
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
        })->get();

        $categories = Category::all();
        $authors = Author::all();

        $books->transform(function ($book) {
            if ($book->cover) {
                $book->cover_url = Storage::url($book->cover);
            } else {
                $book->cover_url = null;
            }
            return $book;
        });

        return response()->json([
            'books' => $books,
            'categories' => $categories,
            'authors' => $authors
        ]);
    }

    public function searchReqApproval(Request $request)
    {
        $query = $request->input('query');

        $reqApprovals = Borrowing::with('users', 'books')
            ->where('status', 'awaiting approval')
            ->whereHas('users', function ($queryBuilder) use ($query) {
                $queryBuilder->where('username', 'LIKE', "%{$query}%");
            })
            ->orderBy('borrow_date', 'desc')
            ->get();

        return response()->json($reqApprovals);
    }

    public function searchBeingBorrowing(Request $request)
    {
        $query = $request->input('query');

        $today = now()->toDateString();

        $beingBorrowing = Borrowing::with('users', 'books')
            ->where('status', 'borrowed')
            ->where('due_date', '>=', $today)
            ->whereHas('users', function ($queryBuilder) use ($query) {
                $queryBuilder->where('username', 'LIKE', "%{$query}%");
            })
            ->orderBy('borrow_date', 'asc')
            ->get();

        return response()->json($beingBorrowing);
    }

    public function searchLateReturn(Request $request)
    {
        $query = $request->input('query');

        $today = now()->toDateString();

        $searchLateReturn = Borrowing::with('users', 'books')
            ->where('status', 'borrowed')
            ->where('due_date', '<', $today)
            ->whereHas('users', function ($queryBuilder) use ($query) {
                $queryBuilder->where('username', 'LIKE', "%{$query}%");
            })
            ->orderBy('borrow_date', 'asc')
            ->get();

        // Loop through each borrowing to calculate the fine
        foreach ($searchLateReturn as $lateReturn) {
            $daysLate = Carbon::parse($lateReturn->due_date)->diffInDays(Carbon::now(), false);
            $lateFine = max($daysLate * 10000, 0); // Calculate late fine
            $lateReturn->fine_price = $lateFine; // Add fine price to the borrowing data
        }

        return response()->json($searchLateReturn);
    }

    public function exportPdf()
    {
        $reportBorrowings = Borrowing::with('users', 'books', 'fines')
            ->whereNotIn('status', ['awaiting approval', 'borrowed'])->get();

        $totalFine = Fine::sum('price');

        $pdf = Pdf::loadView('roles.admin.export_pdf.report_borrowing', compact('reportBorrowings', 'totalFine'));
        return $pdf->stream('borrowing_data.pdf');
    }
}
