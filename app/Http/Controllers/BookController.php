<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
                $book->cover_url = url('storage/' . $book->cover);
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
            $book->cover_url = url('storage/' . $book->cover);
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
        try {
            $request->validate([
                'book_code' => ['required', 'string', 'max:10'],
                'title_book' => ['required', 'string', 'max:50'],
                'synopsis' => ['required', 'string'],
                'cover' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                'language' => ['required', 'string', 'max:10'],
                'categories' => ['required', 'exists:categories,id'],
                'categories.*' => ['exists:categories,id'],
                'authors' => ['required', 'exists:authors,id'],
                'authors.*' => ['exists:authors,id'],
                'stock' => ['integer', 'nullable'],
                'price' => ['integer'],
            ]);

            $book = new Book();
            $book->book_code = strtolower($request->book_code);
            $book->title_book = strtolower($request->title_book);
            $book->synopsis = $request->synopsis;
            $book->language = strtolower($request->language);
            $book->stock = $request->stock;
            $book->price = $request->price;

            if ($request->hasFile('cover')) {
                $coverPath = $this->uploadCover($request->file('cover'));
                $book->cover = $coverPath;
            }

            $book->save();

            // Attach category
            foreach ($request->categories as $c) {
                # code...
                $book->categories()->attach($c);
            }

            // Attach authors
            foreach ($request->authors as $a) {
                $book->authors()->attach($a);
            }

            // Load relationships for response
            $book->load('categories', 'authors');

            return redirect(route('admin.books'));

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the book. Please try again.')->withInput();
        }
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
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'book_code' => ['nullable', 'string', 'max:10'],
                'title_book' => ['nullable', 'string', 'max:50'],
                'synopsis' => ['nullable', 'string'],
                'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                'language' => ['nullable', 'string', 'max:10'],
                'categories' => ['nullable', 'exists:categories,id'],
                'categories.*' => ['exists:categories,id'],
                'authors' => ['nullable', 'exists:authors,id'],
                'authors.*' => ['exists:authors,id'],
                'stock' => ['nullable', 'integer', 'nullable'],
                'price' => ['integer', 'nullable'],
            ]);

            $book = Book::findOrFail($id);
            $book->book_code = strtolower($request->book_code);
            $book->title_book = strtolower($request->title_book);
            $book->synopsis = $request->synopsis;
            $book->language = strtolower($request->language);
            $book->stock = $request->stock;
            $book->price = $request->price;

            if ($request->hasFile('cover')) {
                // Hapus cover lama jika ada
                if ($book->cover) {
                    Storage::delete($book->cover);
                }
                // Upload cover baru
                $coverPath = $this->uploadCover($request->file('cover'));
                $book->cover = $coverPath;
            }

            $book->save();

            // Sync categories
            $book->categories()->sync($request->categories);

            // Sync authors
            $book->authors()->sync($request->authors);

            // Load relationships for response
            $book->load('categories', 'authors');

            return redirect(route('admin.books'))->with('success', 'Book updated successfully.');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the book. Please try again.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $book = Book::findOrFail($id);
            Log::info('Found book:', $book->toArray());

            // Menghapus relasi di tabel pivot
            $book->categories()->detach();
            $book->authors()->detach();

            // Menghapus cover jika ada
            if ($book->cover) {
                Storage::disk('public')->delete($book->cover);
                Log::info('Deleted book cover:', ['cover_path' => $book->cover]);
            }

            // Menghapus buku
            $book->delete();
            return back();
        } catch (Exception $e) {
            return back()->with(['message' => 'Failed to delete book']);
        }
    }

    public function checkStock(Request $request)
    {
        $bookId = $request->input('book_id');
        $book = Book::findOrFail($bookId);

        return response()->json(['stock' => $book->stock]);
    }
}

