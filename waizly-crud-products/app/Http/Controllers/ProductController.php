<?php

namespace App\Http\Controllers;

use App\Http\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->middleware('auth:admin-api');
        $this->productService = $productService;
    }

    public function findAllProducts()
    {
        return $this->productService->findAllProducts();
    }

    public function createProduct(Request $request)
    {
        return $this->productService->createProduct($request);
    }

    public function findProductById($id)
    {
        return $this->productService->findProductById($id);
    }

    public function updateProductById(Request $request, $id)
    {
        return $this->productService->updateProductById($request, $id);
    }

    public function deleteProductById($id)
    {
        return $this->productService->deleteProductById($id);
    }
}
