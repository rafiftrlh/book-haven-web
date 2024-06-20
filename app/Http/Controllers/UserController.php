<?php

namespace App\Http\Controllers;

use App\Models\User;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use function Laravel\Prompts\error;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('categories', 'authors')->get();
        $categories = Category::all();
        return view('books.index', compact('books', 'categories'));
    }

    public function filterByCategory(Request $request)
    {
        $categoryId = $request->get('category_id');
        $books = Book::whereHas('categories', function ($query) use ($categoryId) {
            $query->where('categories.id', $categoryId);
        })->with('categories', 'authors', 'reviews')->get();

        Log::info('Books fetched', ['books' => $books]);

        $books->transform(function ($book) {
            if ($book->cover) {
                $book->cover_url = Storage::url($book->cover);
            } else {
                $book->cover_url = null;
            }
            $book->authors_list = $book->authors->pluck('name')->implode(', ');
            $book->categories_list = $book->categories->pluck('name')->implode(', ');

            $totalRating = $book->reviews->avg('rating');
            $book->total_rating = round($totalRating, 1);

            return $book;
        });

        return response()->json(['books' => $books]);
    }

    public function searchBooks(Request $request)
    {
        $query = $request->input('query');
        $books = Book::with('categories', 'authors', 'reviews')->where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('title_book', 'LIKE', "%{$query}%");
        })->get();

        Log::info('Books fetched', ['books' => $books]);

        $books->transform(function ($book) {
            if ($book->cover) {
                $book->cover_url = Storage::url($book->cover);
            } else {
                $book->cover_url = null;
            }
            $book->authors_list = $book->authors->pluck('name')->implode(', ');
            $book->categories_list = $book->categories->pluck('name')->implode(', ');

            $totalRating = $book->reviews->avg('rating');
            $book->total_rating = round($totalRating, 1);

            return $book;
        });

        return response()->json($books);
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
        // Validasi data
        $request->validate([
            'username' => ['string', 'min:6', 'max:25', 'alpha_num', 'unique:users,username', 'required'],
            'full_name' => ['string', 'required'],
            'email' => ['email', 'unique:users,email', 'required'],
            'password' => ['string', 'min:6', 'required'],
        ]);

        // Hash password
        $request['password'] = Hash::make($request->password);


        // Cek apakah pengguna sudah ada
        $userAlreadyExist = User::where('username', $request->username)
            ->orWhere('email', $request->email)->first();

        if ($userAlreadyExist) {
            return back()->withErrors(['username' => 'Username or email already exists.']);
        }

        try {
            // Buat pengguna baru
            User::create($request->all());

            return back()->with('success', 'User created successfully.');

        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Failed to create user.'])->withInput();
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dataUser = $request->validate([
            'username' => ['string', 'min:6', 'max:25', 'alpha_num'],
            'full_name' => ['string'],
            'email' => ['email'],
            'role' => ['integer']
        ]);

        try {
            User::findOrFail($id)->update($dataUser);

            return back();

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Gagal Update User',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function reset_pw(Request $request)
    {
        $dataUser = $request->validate([
            'username' => ['string', 'min:6', 'max:25', 'alpha_num', 'unique:users,username', 'required'],
            'email' => ['email', 'required'],
            'old_password' => ['string', 'min:6', 'required'],
            'new_password' => ['string', 'min:6', 'required'],
        ]);

        // Ambil data pengguna berdasarkan username dan email
        $userCheck = User::where('username', $dataUser['username'])
            ->where('email', $dataUser['email'])
            ->first();

        if ($userCheck) {
            // Jika pengguna ditemukan, periksa kecocokan password
            if (Hash::check($dataUser['old_password'], $userCheck->password)) {

                try {
                    User::where('username', $request->username)->update([
                        'password' => Hash::make($request->new_password)
                    ]);

                    return response()->json([
                        'message' => 'Berhasil Reset Password',
                        'data' => $userCheck
                    ]);
                } catch (\Throwable $th) {
                    return response()->json([
                        'message' => 'Gagal Reset Password',
                        'data' => $th->getMessage()
                    ]);
                }

            } else {
                // Password tidak cocok
                return response()->json([
                    'message' => 'Password lama tidak sesuai.'
                ], 422); // Gunakan kode status 422 untuk menyatakan bahwa permintaan tidak dapat diproses karena entitas tidak valid
            }
        } else {
            // Pengguna tidak ditemukan
            return response()->json([
                'message' => 'Username atau email tidak ditemukan.'
            ], 404); // Gunakan kode status 404 untuk menyatakan bahwa sumber daya yang diminta tidak ditemukan
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Mencari pengguna berdasarkan username
        $userCheck = User::where('id', $id)->first();

        if (!$userCheck) {
            // Jika pengguna tidak ditemukan, kirim response 404 Not Found
            return response()->json([
                'message' => 'Pengguna tidak ditemukan'
            ], 404);
        }

        try {
            // Hapus pengguna
            $userCheck->delete();

            return back();

            // return response()->json([
            //     'message' => 'Berhasil Menghapus Akun !!',
            //     'data' => $userCheck
            // ]);
        } catch (\Throwable $th) {
            throw $th;
        }


    }

}
