<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

    // A Home oficial é a listagem de produtos (Tela principal)
    Route::get('/', [ProductController::class, 'index'])->name('products.index');

    // Evita erro 405: se alguém digitar /products, manda para a home /
    Route::get('/products', function () {
        return redirect()->route('products.index');
    });

    Route::middleware('auth')->group(function () {

    // CRUD de Produtos: Protege apenas as ações de alteração (Create, Store, Edit, Update, Delete)
    // O 'index' não entra aqui pois já é a nossa Home pública
    Route::resource('products', ProductController::class)->except(['index']);

    Route::get('/dashboard', function () {
        return redirect()->route('products.index');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
