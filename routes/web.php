<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Author\AuthorController;
use App\Http\Controllers\Book\BookController;
use App\Http\Middleware\HandleInertiaRequests;

Route::middleware('check.auth')->group(function () {
    Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
    Route::post('/authors', [AuthorController::class, 'store'])->name('authors.store');
    Route::get('/authors/create', [AuthorController::class, 'create'])->name('authors.create');
    Route::get('/authors/edit/{id}', [AuthorController::class, 'edit'])->name('authors.edit');
    Route::post('/authors/update', [AuthorController::class, 'update'])->name('authors.update');
    Route::delete('/authors/destroy', [AuthorController::class, 'destroy'])->name('authors.destroy');

    Route::get('/books/{id}', [BookController::class, 'index'])->name('books.index');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/create/{id}', [BookController::class, 'create'])->name('books.create');
    Route::get('/books/edit/{id}', [BookController::class, 'edit'])->name('books.edit');
    Route::post('/books/update', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/destroy', [BookController::class, 'destroy'])->name('books.destroy');

    Route::post('/logout', [AuthController::class, 'destroy'])->name('auth.destroy');
});

Route::middleware('check.guest')->group(function () {
    Route::get('/login', [AuthController::class, 'show'])->name('auth.show');
    Route::post('/login', [AuthController::class, 'store'])->name('auth.store');
});

Route::get('/{any}', function () {
    abort(404);
})
->where('any', '.*')
->middleware(HandleInertiaRequests::class);
