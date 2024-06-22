<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\returnSelf;

class AuthController extends Controller
{
    use Authenticatable;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // kita ambil data user lalu simpan pada variable $user
        $user = Auth::user();
        // kondisi jika user nya ada 
        if ($user) {
            // jika user nya memiliki role admin
            if ($user->role == 1) {
                return redirect()->intended('admin');
            }
            // cek jika role user officer maka arahkan ke halaman admin
            else if ($user->role == 2) {
                return redirect()->intended('officer');
            }
            // tapi jika role user nya user biasa maka arahkan ke halaman user
            else if ($user->role == 3) {
                return redirect()->intended('user');
            }

        }
        return view('login');
    }

    public function proses_login(Request $request)
    {
        // kita buat validasi pada saat tombol login di klik
        // validas nya username & password wajib di isi 
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);


        // ambil data request username & password saja 
        $credential = $request->only('username', 'password');

        // cek jika data username dan password valid (sesuai) dengan data
        if (Auth::attempt($credential)) {
            // kalau berhasil simpan data user ya di variabel $user
            $user = Auth::user();
            // cek lagi jika role user admin maka arahkan ke halaman admin
            if ($user->role == 1) {
                return redirect()->intended('admin');
            }
            // cek jika role user officer maka arahkan ke halaman officer   
            else if ($user->role == 2) {
                return redirect()->intended('officer');
            }
            // tapi jika role user nya user biasa maka arahkan ke halaman user
            else if ($user->role == 3) {
                return redirect()->intended('home');
            }
            // jika belum ada role maka ke halaman /
            return redirect()->intended('/');
        }

        // jika ga ada data user yang valid maka kembalikan lagi ke halaman login
        // pastikan kirim pesan error juga kalau login gagal ya
        return redirect('login')
            ->withInput()
            ->withErrors(['login_gagal' => 'These credentials does not match our records']);



    }

    public function register()
    {
        // tampilkan view register
        return view('register');
    }


    // aksi form register
    public function proses_register(Request $request)
    {
        //. kita buat validasi nih buat proses register
        // validasinya yaitu semua field wajib di isi
        // validasi username itu harus unique atau tidak boleh duplicate username ya
        $validator = Validator::make($request->all(), [
            'username' => ['string', 'min:6', 'max:25', 'alpha_num', 'unique:users,username', 'required'],
            'full_name' => ['string', 'required'],
            'email' => ['email', 'unique:users,email', 'required'],
            'password' => ['string', 'min:6', 'required'],
        ]);

        // kalau gagal kembali ke halaman register dengan munculkan pesan error
        if ($validator->fails()) {
            return redirect('/register')
                ->withErrors($validator)
                ->withInput();
        }
        // kalau berhasil isi role & hash passwordnya ya biar secure
        // $request['role'] = 'user';
        $request['password'] = Hash::make($request->password);

        // masukkan semua data pada request ke table user
        User::create($request->all());

        // kalo berhasil arahkan ke halaman login
        return redirect()->route('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Ambil data request username & password
        $credentials = $request->only('username', 'password');

        // Cek apakah username dan password valid
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Cek apakah role user adalah 3
            if ($user->role == 3) {
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'user' => $user,
                    'access_token' => $token,
                    'token_type' => 'Bearer'
                ]);
            } else {
                // Return error jika role tidak sesuai
                return response()->json(['error' => 'Unauthorized role'], 403);
            }
        }

        // Return error jika login gagal
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        // logout itu harus menghapus session nya 
        $request->session()->flush();

        // jalan kan juga fungsi logout pada auth 
        Auth::logout();

        // kembali kan ke halaman login
        return Redirect('login');
    }

}
