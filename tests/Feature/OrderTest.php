<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;



class OrderTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_order_created(): void
    {
        $response = $this->postJson('/api/orders', [
            'id'=> 'A0000001',
            'name' => 'John',
            'currency' => 'TWD',
            'price' => 100,
            'address' => [
                'city' => 'Taipei',
                'street' => 'Taipei 101',
                'district' => 'Xinyi'
            ]
        ]);
        $response->assertStatus(200);
    }

    public function test_order_created_with_invalid_currency(): void
    {
        $response = $this->postJson('/api/orders', [
            'id'=> 'A0000001',
            'name' => 'John',
            'currency' => 'INVALID',
            'price' => 100,
            'address' => [
                'city' => 'Taipei',
                'street' => 'Taipei 101',
                'district' => 'Xinyi'
            ]
        ]);
        $response->assertStatus(422);
    }

    public function test_order_created_with_invalid_address(): void
    {
        $response = $this->postJson('/api/orders', [
            'id'=> 'A0000001',
            'name' => 'John',
            'currency' => 'TWD',
            'price' => 100,
            'address' => 'invalid_address'
        ]);
        $response->assertStatus(422);
    }

    public function test_order_created_with_invalid_price(): void
    {
        $response = $this->postJson('/api/orders', [
            'id'=> 'A0000001',
            'name' => 'John',
            'currency' => 'TWD',
            'price' => 'invalid_price',
            'address' => [
                'city' => 'Taipei',
                'street' => 'Taipei 101',
                'district' => 'Xinyi'
            ]
        ]);
        $response->assertStatus(422);
    }

    public function test_order_created_with_invalid_id(): void
    {
        $response = $this->postJson('/api/orders', [
            'id'=> null,
            'name' => 'John',
            'currency' => 'TWD',
            'price' => 100,
            'address' => [
                'city' => 'Taipei',
                'street' => 'Taipei 101',
                'district' => 'Xinyi'
            ]
        ]);
        $response->assertStatus(422);
    }

    public function test_order_created_without_some_fields(): void
    {
        $response = $this->postJson('/api/orders', [
            'id'=> 'A0000001',
            'name' => 'John',
            'currency' => 'TWD',
            'price' => 100,
        ]);
        $response->assertStatus(422);

        $response = $this->postJson('/api/orders', [
            'id'=> 'A0000001',
            'name' => 'John',
            'price' => 100,
            'address' => [
                'city' => 'Taipei',
                'street' => 'Taipei 101',
                'district' => 'Xinyi'
            ]
        ]);
        $response->assertStatus(422);

        $response = $this->postJson('/api/orders', [
            'id'=> 'A0000001',
            'currency' => 'TWD',
            'price' => 100,
            'address' => [
                'city' => 'Taipei',
                'street' => 'Taipei 101',
                'district' => 'Xinyi'
            ]
        ]);
        $response->assertStatus(422);
    }
    

    public function test_get_order(): void
    {
        $pre_insert_data = [
            'id'=> 'A0000001',
            'name' => 'John',
            'currency' => 'USD',
            'price' => 2024,
            'address' => json_encode([
                'city' => 'Taipei',
                'street' => 'Taipei 101',
                'district' => 'Xinyi'
            ])
        ];
        DB::table('orders_usd')->insert($pre_insert_data);
        $response = $this->get('/api/orders/A0000001');
        $response->assertStatus(200);
        $response->assertJson([
            'id'=> 'A0000001',
            'name' => 'John',
            'currency' => 'USD',
            'price' => 2024,
            'address' => [
                'city' => 'Taipei',
                'street' => 'Taipei 101',
                'district' => 'Xinyi'
            ]
        ]);
        
    }

    public function test_order_not_found(): void
    {
        $response = $this->get('/api/orders/A0000002');
        $response->assertStatus(404);
    }

    public function test_order_not_found_with_invalid_id(): void
    {
        $response = $this->get('/api/orders/invalid_id');
        $response->assertStatus(404);
    }
}
