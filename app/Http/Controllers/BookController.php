<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('categories', 'authors')->get();

        $books->transform(function ($book) {
            if ($book->cover) {
                $book->cover_url = Storage::url($book->cover);
            } else {
                $book->cover_url = null;
            }
            return $book;
        });

        return response()->json(['books' => $books]);
    }

    public function show($id)
    {
        $book = Book::with('categories', 'authors')->find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        if ($book->cover) {
            $book->cover_url = Storage::url($book->cover);
        } else {
            $book->cover_url = null;
        }

        return response()->json(['book' => $book]);
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
        $validated = $request->validate([
            'book_code' => 'required|string|max:10',
            'title_book' => 'required|string|max:50',
            'synopsis' => 'required|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'language' => 'required|string|max:10',
            'categories' => 'required|exists:categories,id',
            'authors' => 'required|exists:authors,id',
        ]);

        // return explode(",", $validated['categories']);

        $book = new Book();
        $book->book_code = $validated['book_code'];
        $book->title_book = $validated['title_book'];
        $book->synopsis = $validated['synopsis'];
        $book->language = $validated['language'];

        if ($request->hasFile('cover')) {
            $coverPath = $this->uploadCover($request->file('cover'));
            $book->cover = $coverPath;
        }

        $book->save();

        // Attach category
        foreach (explode(",", $validated['categories']) as $v) {
            # code...
            $book->categories()->attach($v);
        }

        // Attach authors
        foreach (explode(",", $validated['authors']) as $v) {
            $book->authors()->attach($v);
        }

        // Load relationships for response
        $book->load('categories', 'authors');

        return response()->json(['message' => 'Book created successfully', 'book' => $book], 201);
    }

    private function uploadCover($cover)
    {
        $coverPath = $cover->store('covers', 'public');
        return $coverPath;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
