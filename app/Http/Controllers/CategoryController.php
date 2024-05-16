<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return $categories;
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

        // kalau gagal kembali ke halaman create category dengan munculkan pesan error
        // if ($validator->fails()) {
        //     return redirect('admin/categories/create')
        //         ->withErrors($validator)
        //         ->withInput();
        // }

        // masukkan semua data pada request ke table categories
        Category::create($request->all());

        // kalo berhasil arahkan ke halaman login
        // return redirect()->route('categories');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $findCategory = Category::findOrFail($id);

        return $findCategory;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
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
            Category::findOrFail($id)->update($request->all());

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
        $categoryCheck = Category::where('id', $id)->first();

        if (!$categoryCheck) {
            // Jika category tidak ditemukan, kirim response 404 Not Found
            return response()->json([
                'message' => 'Category tidak ditemukan'
            ], 404);
        }

        try {
            // Hapus pengguna
            $categoryCheck->delete();

            // return back();

            return response()->json([
                'message' => 'Berhasil Menghapus Category !!',
                'data' => $categoryCheck
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
