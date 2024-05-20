<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
            'book_code' => ['required', 'string', 'max:10', 'unique:books,book_code'],
            'title_book' => ['required', 'string', 'max:50'],
            'synopsis' => ['required', 'string'],
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'language' => ['required', 'string', 'max:10'],
            'categories' => ['required', 'exists:categories,id'],
            'authors' => ['required', 'exists:authors,id'],
            'stock' => ['integer', 'nullable'],
        ]);

        $book = new Book();
        $book->book_code = $validated['book_code'];
        $book->title_book = strtolower($validated['title_book']);
        $book->synopsis = $validated['synopsis'];
        $book->language = $validated['language'];
        $book->stock = $validated['stock'];

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
    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari formulir
        $validator = Validator::make($request->all(), [
            'title_book' => 'required|max:100',
            'synopsis' => 'required|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'language' => 'required|string|max:10',
            'stock' => 'required|integer|min:0',
        ]);

        // Jika validasi gagal, kembalikan respons dengan pesan kesalahan
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Ambil buku berdasarkan ID
        $book = Book::findOrFail($id);

        // Perbarui atribut-atribut buku sesuai data yang diterima
        $book->title_book = $request->title_book;
        $book->language = $request->language;
        $book->synopsis = $request->synopsis;
        $book->stock = $request->stock;

        // Jika terdapat file gambar yang diunggah, proses penyimpanannya
        if ($request->hasFile('cover')) {
            $coverPath = $this->uploadCover($request->file('cover'));
            $book->cover = $coverPath;
        }

        // Simpan perubahan buku
        $book->save();
        // Alert::success('Success', 'Buku Behasil di Edit!');

        // Jika berhasil, kembalikan respons sukses
        return response()->json(['message' => 'Book updated successfully'], 200);
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
            Log::info('Book deleted successfully:', ['book_id' => $id]);

            return response()->json(['message' => 'Book deleted successfully'], 200);
        } catch (Exception $e) {
            Log::error('Error deleting book:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Failed to delete book', 'error' => $e->getMessage()], 500);
        }
    }
}

