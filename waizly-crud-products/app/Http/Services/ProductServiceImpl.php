<?php

namespace App\Http\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductServiceImpl implements ProductService
{

    public function findAllProducts()
    {
        $products = Product::all();
        if ($products->count() > 0) {
            return new ProductResource(200, 'List data products', $products);
        } else {
            return new ProductResource(404, 'No records found', []);
        }
    }

    public function createProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required',
            'stock' => 'required',
            'brand' => 'required|string|max:255',
            'category' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            Log::info($validator->messages());
            return new ProductResource(422, 'Request data invalid', $validator->messages());
        } else {
            $product = Product::create($validator->validate());
        }

        if ($product) {
            Log::info('Product created successfull');
            return new ProductResource(200, 'Product created successfull', $product);
        } else {
            Log::error('Something went wrong');
            return new ProductResource(500, 'Something went wrong', []);
        }
    }

    public function findProductById($id)
    {
        $products = Product::find($id);
        if ($products) {
            Log::info('Product with id: ' . $id . ' found');
            return new ProductResource(200, 'Product found', $products);
        } else {
            Log::info('Product with id: ' . $id . ' Not found');
            return new ProductResource(404, 'No product found', []);
        }
    }

    public function updateProductById(Request $request, $id)
    {
        $product = Product::find($id);
        if ($product) {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'price' => 'required',
                'stock' => 'required',
                'brand' => 'required|string|max:255',
                'category' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                Log::info($validator->messages());
                return new ProductResource(422, 'Request data invalid', $validator->messages());
            } else {
                $productUpdate = $product->update($validator->validate());
                if ($productUpdate) {
                    Log::info('Product with id : ' . $id . ' updated successfull');
                    return new ProductResource(200, 'Product updated successfull', $product);
                } else {
                    Log::error('Something went wrong');
                    return new ProductResource(500, 'Something went wrong', []);
                }
            }
        } else {
            Log::info('No product found');
            return new ProductResource(404, 'No product found', []);
        }
    }

    public function deleteProductById($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            Log::info('Product with id : ' . $id . ' deleted successfull');
            return new ProductResource(200, 'Product deleted successfull', $product);
        } else {
            Log::info('Product with id : ' . $id . ' not found');
            return new ProductResource(404, 'No product found', []);
        }
    }
}
