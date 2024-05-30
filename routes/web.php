<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return redirect('/login');
});

// Route::view('/login', 'login')->name('login');
// Route::view('/register', 'register')->name('register');
// Route::view('/bookcatalog', '__bookcatalog')->name('bookcatalog');




// web.php



// metode nya get lalu masukkan namespace AuthController 
// attribute name merupakan penamaan dari route yang kita buat
// kita tinggal panggil fungsi route(name) pada layout atau controller
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register');

// Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('proses_login', [AuthController::class, 'proses_login'])->name('proses_login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
// Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::post('proses_register', [AuthController::class, 'proses_register'])->name('proses_register');

// kita atur juga untuk middleware menggunakan group pada routing
// didalamnya terdapat group untuk mengecek kondisi login
// jika user yang login merupakan admin maka akan diarahkan ke AdminController
// jika user yang login merupakan user biasa maka akan diarahkan ke UserController
Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['cek_login:1']], function () {
        Route::get('admin', [AdminController::class, 'index']);
    });

    Route::group(['middleware' => ['cek_login:2']], function () {
        Route::get('officer', [OfficerController::class, 'index'])->name("officer.home");
        Route::get('officer/data_buku', [OfficerController::class, 'books'])->name('officer.data_buku');
        Route::get('officer/add-category', [OfficerController::class, 'categories'])->name('officer.add_category');
        Route::get('officer/confirm_peminjaman', [OfficerController::class, 'peminjaman'])->name('officer.confirm_peminjaman');
        Route::get('officer/add_author', [OfficerController::class, 'authors'])->name('officer.add_author');
        Route::get('officer/books', [OfficerController::class, 'books'])->name('officer.books');
        Route::get('officer/books_create', [OfficerController::class, 'createBook'])->name('officer.books_create');
    });

    Route::group(['middleware' => ['cek_login:3']], function () {
        Route::view('home', 'roles.customer.index')->name('customer.home');
        Route::view('notification', 'roles.customer.index')->name('customer.notification');
        Route::get(
            'bookcatalog',
            function () {
                $categories = ["all", "fiction", "non fiction", "history", "arts", "science and technology"];
                return view('roles.customer.index', compact("categories"));
            }
        )->name('customer.bookcatalog');

    });
    // route untuk petugas


});



// Route::get('/dashboard', [AdminController::class, 'show_user'])->name('dashboard.admin');
// Route::view('/home', 'roles.customer.index')->name('dashboard.customer');
