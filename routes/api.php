<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::put('/resetpw', [UserController::class, 'reset_pw'])->name('users.resetpw');

Route::resource('users', UserController::class);

Route::post('/admin/filter-by-role', [AdminController::class, 'filterByRole'])->name('admin.filterByRole');
Route::get('/admin/search-users', [AdminController::class, 'searchUsers'])->name('admin.searchUsers');
Route::get('/admin/search-categories', [AdminController::class, 'searchCategories'])->name('admin.searchCategories');
Route::get('/admin/search-authors', [AdminController::class, 'searchAuthors'])->name('admin.searchAuthors');
Route::get('/admin/search-books', [AdminController::class, 'searchBooks'])->name('admin.searchBooks');

Route::resource('categories', CategoryController::class);
Route::post('/categories/filterByDeletedStatus', [CategoryController::class, 'filterByDeletedStatus'])->name('categories.filterByDeletedStatus');
Route::post('/categories/restoreCategory/{id}', [CategoryController::class, 'restore'])->name('categories.restore');

Route::resource('authors', AuthorController::class);
Route::post('/authors/filterByDeletedStatus', [AuthorController::class, 'filterByDeletedStatus'])->name('authors.filterByDeletedStatus');
Route::post('/authors/restoreAuthor/{id}', [AuthorController::class, 'restore'])->name('authors.restore');

Route::resource('books', BookController::class);