<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function findAllProducts()
    {
        return $this->productService->findAllProducts();
    }

    public function createProduct(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized.'], 401);
        }
        return $this->productService->createProduct($request);
    }

    public function findProductById($id)
    {
        return $this->productService->findProductById($id);
    }

    public function updateProductById(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized.'], 401);
        }
        return $this->productService->updateProductById($request, $id);
    }

    public function deleteProductById($id)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized.'], 401);
        }
        return $this->productService->deleteProductById($id);
    }
}
