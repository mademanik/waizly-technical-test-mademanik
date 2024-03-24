<?php

namespace App\Http\Services;

use Illuminate\Http\Request;

interface ProductService
{
    public function findAllProducts();
    public function createProduct(Request $request);
    public function findProductById($id);
    public function updateProductById(Request $request, $id);
    public function deleteProductById($id);
}
