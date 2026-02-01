<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use App\Http\Requests\StoreUpdateProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductApiController extends Controller
{
    public function __construct(protected ProductService $service) {}

    /**
     * Listagem de produtos padronizada.
     */
    public function index(Request $request)
    {
        $products = $this->service->getAllPaginated($request->all());

        return ProductResource::collection($products)->additional([
            'message' => 'Produtos listados com sucesso',
            'errors' => null
        ]);
    }

    /**
     * Criação de produto padronizada (Retorna 201).
     */
    public function store(StoreUpdateProductRequest $request): JsonResponse
    {
        $product = $this->service->createProduct($request->validated());

        return (new ProductResource($product))
            ->additional([
                'message' => 'Produto criado com sucesso!',
                'errors' => null
            ])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Exibição de um produto específico padronizada.
     */
    public function show(Product $product)
    {
        return (new ProductResource($product))->additional([
            'message' => 'Produto encontrado com sucesso',
            'errors' => null
        ]);
    }

    /**
     * Atualização de produto padronizada.
     */
    public function update(StoreUpdateProductRequest $request, Product $product)
    {
        $updatedProduct = $this->service->updateProduct($product, $request->validated());

        return (new ProductResource($updatedProduct))->additional([
            'message' => 'Produto atualizado com sucesso!',
            'errors' => null
        ]);
    }

    /**
     * Exclusão de produto padronizada.
     */
    public function destroy(Product $product): JsonResponse
    {
        $this->service->deleteProduct($product);

        return response()->json([
            'data' => null,
            'message' => 'Produto removido com sucesso!',
            'errors' => null
        ], 200);
    }
}
