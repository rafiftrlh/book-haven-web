<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
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
        $dataUser = $request->validate([
            'username' => ['string', 'min:6', 'max:15', 'unique:users,username', 'required'],
            'full_name' => ['string', 'required'],
            'email' => ['email', 'unique:users,email', 'required'],
            'password' => ['string', 'min:6', 'required'],
            'role' => ['nullable', 'integer']
        ]);

        // Hash password
        $dataUser['password'] = Hash::make($dataUser['password']);

        // Handle nullable role
        if (!isset($dataUser['role'])) {
            unset($dataUser['role']); // remove 'role' from $dataUser if it's not set
        }

        try {
            User::create($dataUser);

            return response()->json([
                'message' => 'Berhasil Membuat Akun',
                'data' => $dataUser
            ], 202);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Gagal Membuat Akun',
                'error' => $th->getMessage()
            ], 400);
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
    public function update(Request $request, string $username)
    {
        $dataUser = $request->validate([
            'role' => ['integer', 'nullable']
        ]);

        try {
            User::where('username', $username)->update([
                'role' => $request->role
            ]);

            return response()->json([
                'message' => 'Berhasil Mengubah Role',
                'data' => $dataUser
            ], 202);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Gagal Mengubah Role',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function reset_pw(Request $request)
    {
        $dataUser = $request->validate([
            'username' => ['string', 'min:6', 'max:15', 'required'],
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
    public function destroy(string $username)
    {
        // Mencari pengguna berdasarkan username
        $userCheck = User::where('username', $username)->first();

        if (!$userCheck) {
            // Jika pengguna tidak ditemukan, kirim response 404 Not Found
            return response()->json([
                'message' => 'Pengguna tidak ditemukan'
            ], 404);
        }

        try {
            // Hapus pengguna
            $userCheck->delete();

            return response()->json([
                'message' => 'Berhasil Menghapus Akun !!',
                'data' => $userCheck
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }


    }

}
