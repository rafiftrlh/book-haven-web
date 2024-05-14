<?php

use App\Http\Controllers\AdminController;
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

Route::view('/login', 'login')->name('login');
Route::view('/register', 'register')->name('register');
Route::view('/bookcatalog', '__bookcatalog')->name('bookcatalog');


Route::get('/dashboard', [AdminController::class, 'show_user'])->name('dashboard.admin');
Route::view('/home', 'roles.customer.index')->name('dashboard.customer');
Route::view('/notification', 'roles.customer.index')->name('dashboard.notification');
Route::get('/bookcatalog', function () {
    $categories = ["all", "fiction", "non fiction", "history", "arts", "science and technology"];
   return view( 'roles.customer.index', compact("categories"));
}
)->name('bookcatalog');

// web.php



