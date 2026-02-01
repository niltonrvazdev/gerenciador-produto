<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'min_price', 'min_stock']);
        $products = $this->productService->getAllPaginated($filters);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(StoreUpdateProductRequest $request)
    {
        $this->productService->createProduct($request->validated());

        return redirect()
            ->route('products.index')
            ->with('success', 'Produto Cadastrado com Sucesso!');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(StoreUpdateProductRequest $request, Product $product)
    {
        $this->productService->updateProduct($product, $request->validated());

        return redirect()
            ->route('products.index')
            ->with('success', 'Produto Atualizado com Sucesso!');
    }

    public function destroy(Product $product)
    {
        $this->productService->deleteProduct($product);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produto removido com sucesso!');
    }
}
