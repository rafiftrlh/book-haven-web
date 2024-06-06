<?php

namespace App\Http\Controllers;

use App\Models\RatingBook;
use Illuminate\Http\Request;

class RatingBookController extends Controller
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
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'review' => 'required',
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        // Simpan ulasan dan peringkat ke database
        $review = new RatingBook();
        $review->book_id = $request->input('book_id');
        $review->user_id = $request->input('user_id'); // Sesuaikan dengan sistem autentikasi Anda
        $review->review = $request->input('review');
        $review->rating = $request->input('rating');
    $review->save();

        // Redirect atau kirim respons sesuai kebutuhan aplikasi Anda
        return redirect()->back()->with('success', 'Review submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RatingBook $ratingBook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RatingBook $ratingBook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RatingBook $ratingBook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RatingBook $ratingBook)
    {
        //
    }
}
