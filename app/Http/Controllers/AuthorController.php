<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();

        return $authors;
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
        $validator = Validator::make($request->all(), [
            'name' => ['string', 'min:3', 'max:25', 'unique:categories,name', 'required'],
        ]);

        if ($validator->fails()) {
            return redirect('admin/authors')
                ->withErrors($validator)
                ->withInput();
        }

        // masukkan semua data pada request ke table categories
        Author::create($request->all());

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $findAuthor = Author::findOrFail($id);

        return $findAuthor;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Validator::make($request->all(), [
            'name' => ['string', 'min:3', 'max:25', 'unique:categories,name', 'required'],
        ]);

        try {
            Author::findOrFail($id)->update(['name' => strtolower($request->name)]);

            return back();

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Gagal Update Author',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $authorCheck = Author::where('id', $id)->first();

        if (!$authorCheck) {
            // Jika Author tidak ditemukan, kirim response 404 Not Found
            return response()->json([
                'message' => 'Author tidak ditemukan'
            ], 404);
        }

        try {
            // Hapus pengguna
            $authorCheck->delete();

            return back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function filterByDeletedStatus(Request $request)
    {
        $status = $request->status;

        if ($status == 'all') {
            $authors = Author::withTrashed()->orderBy('deleted_at')->get();
        } elseif ($status == 'deleted') {
            $authors = Author::onlyTrashed()->orderBy('name')->get();
        } else {
            $authors = Author::orderBy('name')->get();
        }

        return response()->json($authors);
    }

    public function restore($id)
    {
        $author = Author::onlyTrashed()->findOrFail($id);
        $author->restore();

        return response()->json(['message' => 'Author restored successfully.']);
    }

}
