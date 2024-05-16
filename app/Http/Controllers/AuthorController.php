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

        // kalau gagal kembali ke halaman create author dengan munculkan pesan error
        // if ($validator->fails()) {
        //     return redirect('admin/categories/create')
        //         ->withErrors($validator)
        //         ->withInput();
        // }

        // masukkan semua data pada request ke table categories
        Author::create($request->all());

        // kalo berhasil arahkan ke halaman login
        // return redirect()->route('categories');
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
        $validator = Validator::make($request->all(), [
            'name' => ['string', 'min:3', 'max:25', 'unique:categories,name', 'required'],
        ]);

        try {
            Author::findOrFail($id)->update($request->all());

            // return back();

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Gagal Update User',
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

            // return back();

            return response()->json([
                'message' => 'Berhasil Menghapus Author !!',
                'data' => $authorCheck
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
