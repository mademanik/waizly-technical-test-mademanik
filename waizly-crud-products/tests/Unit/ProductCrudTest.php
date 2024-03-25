<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    public function jwtInitToken()
    {
        $user = User::create([
            'name' => 'admin test',
            'email' => 'admintest@gmail.com',
            'password' => bcrypt('123456'),
            'role' => 'admin',
        ]);

        $loginResponse = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => '123456',
        ]);

        $loginResponse->assertStatus(Response::HTTP_OK);
        return $loginResponse->json('token');
    }

    public function testCreateProductWithValidData()
    {
        $token = $this->jwtInitToken();

        $requestData = [
            'title' => 'Thronmax Microphone Test',
            'description' => 'This is a test product.',
            'price' => 500000,
            'stock' => 100,
            'brand' => 'Thronmax Test',
            'category' => 'Microphone Test',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/products', $requestData);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'message' => 'Product created successfull',
            ])
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'title',
                    'description',
                    'price',
                    'stock',
                    'brand',
                    'category',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    public function testFindAllProductsWithProductsAvailable()
    {
        $token = $this->jwtInitToken();

        Product::create([
            'title' => 'Product 1',
            'description' => 'Description for Product 1',
            'price' => 100000,
            'stock' => 100,
            'brand' => 'Brand A',
            'category' => 'Category X',
        ]);

        Product::create([
            'title' => 'Product 2',
            'description' => 'Description for Product 2',
            'price' => 100000,
            'stock' => 50,
            'brand' => 'Brand B',
            'category' => 'Category Y',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/products');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'List data products',
            ])
            ->assertJsonStructure([
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'price',
                        'stock',
                        'brand',
                        'category',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);
    }

    public function testFindProductById()
    {
        $token = $this->jwtInitToken();

        $product = Product::create([
            'title' => 'Product 1',
            'description' => 'Description for Product 1',
            'price' => 100000,
            'stock' => 100,
            'brand' => 'Brand A',
            'category' => 'Category X',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/products/' . $product->id);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'Product found',
            ])
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'title',
                    'description',
                    'price',
                    'stock',
                    'brand',
                    'category',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    public function testDeleteProductById()
    {
        $token = $this->jwtInitToken();

        $product = Product::create([
            'title' => 'Product 1',
            'description' => 'Description for Product 1',
            'price' => 100000,
            'stock' => 100,
            'brand' => 'Brand A',
            'category' => 'Category X',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson('/api/product/' . $product->id);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'Product deleted successfull',
            ]);
    }

    public function testUpdateProductById()
    {
        $token = $this->jwtInitToken();

        $product = Product::create([
            'title' => 'Product 1',
            'description' => 'Description for Product 1',
            'price' => 100000,
            'stock' => 100,
            'brand' => 'Brand A',
            'category' => 'Category X',
        ]);

        $newData = [
            'title' => 'New Title',
            'description' => 'New Description',
            'price' => 300000,
            'stock' => 50,
            'brand' => 'New Brand',
            'category' => 'New Category',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson('/api/product/' . $product->id, $newData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'Product updated successfull',
            ]);

        $this->assertDatabaseHas('products', array_merge(['id' => $product->id], $newData));
    }

}
