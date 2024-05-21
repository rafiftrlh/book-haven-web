<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all()->sortBy('role');
        return view('roles.admin.index', compact('users'));
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

        return view('roles.admin.index', compact('categories'));
    }

    public function authors()
    {
        $authors = Author::withTrashed()->orderBy('deleted_at')->get();

        return view('roles.admin.index', compact('authors'));
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
}
