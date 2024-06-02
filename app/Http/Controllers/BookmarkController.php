<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function storeOrDelete(Request $request)
    {
        $request->validate([
            'book_id' => ['required', 'exists:books,id'],
            'user_id' => ['required', 'exists:users,id']
        ]);

        $userId = $request->user_id;
        $bookId = $request->book_id;

        $isBookmarked = Bookmark::where('user_id', $userId)->where('book_id', $bookId)->first();

        if ($isBookmarked) {
            // If book is already bookmarked, remove it
            $isBookmarked->delete();
            return response()->json(['message' => 'Book bookmark removed successfully.'], 200);
        } else {
            // If book is not bookmarked, add it
            Bookmark::create([
                'user_id' => $userId,
                'book_id' => $bookId
            ]);

            return response()->json(['message' => 'Book bookmarked successfully.'], 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Bookmark $bookmark)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bookmark $bookmark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bookmark $bookmark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'book_id' => ['required', 'exists:books,id']
        ]);

        $user = User::findOrFail($request->user_id);

        $user->bookmarks()->detach($request->book_id);

        return response()->json(['message' => 'Book bookmark removed successfully.'], 200);
    }
}
