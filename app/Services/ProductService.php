<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{

    public function getAllPaginated(array $filters, int $perPage = 12): LengthAwarePaginator
    {
        $query = Product::query();

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        if (isset($filters['min_stock']) && $filters['min_stock'] !== '') {
            $query->where('stock', '>=', $filters['min_stock']);
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    public function createProduct(array $data): Product
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {

            $path = $data['image']->store('products', 'public');
            $data['image_url'] = $path;
        }

        return Product::create($data);
    }

    public function updateProduct(Product $product, array $data): Product
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            // Remove a imagem antiga do disco antes de salvar a nova
            if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
                Storage::disk('public')->delete($product->image_url);
            }

            $path = $data['image']->store('products', 'public');
            $data['image_url'] = $path;
        }

        $product->update($data);
        return $product;
    }


    public function deleteProduct(Product $product): bool
    {
        if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
            Storage::disk('public')->delete($product->image_url);
        }

        return $product->delete();
    }
}
