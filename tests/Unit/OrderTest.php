<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Bus;
class OrderTest extends TestCase
{
    
    use RefreshDatabase;
    public function test_twd_order_insert()
    {
        $orderInsert = new \App\Services\OrderInsert\OrderInsertTWD();
        $data = [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => json_encode([
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ]),
            'price' => '2050',
            'currency' => 'TWD'
        ];
        $result = $orderInsert->orderInsert($data);
        $this->assertDatabaseHas('orders_twd', $data);
    }

    public function test_usd_order_insert()
    {
        $orderInsert = new \App\Services\OrderInsert\OrderInsertUSD();
        $data = [
            'id' => 'A0000002',
            'name' => 'Melody Holiday Inn',
            'address' => json_encode([
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ]),
            'price' => '100',
            'currency' => 'USD'
        ];
        $result = $orderInsert->orderInsert($data);
        $this->assertDatabaseHas('orders_usd', $data);
    }

    public function test_jpy_order_insert()
    {
        $orderInsert = new \App\Services\OrderInsert\OrderInsertJPY();
        $data = [
            'id' => 'A0000003',
            'name' => 'Melody Holiday Inn',
            'address' => json_encode([
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ]),
            'price' => '1000',
            'currency' => 'JPY'
        ];
        $result = $orderInsert->orderInsert($data);
        $this->assertDatabaseHas('orders_jpy', $data);
    }

    public function test_rmb_order_insert()
    {
        $orderInsert = new \App\Services\OrderInsert\OrderInsertRMB();
        $data = [
            'id' => 'A0000004',
            'name' => 'Melody Holiday Inn',
            'address' => json_encode([
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ]),
            'price' => '100',
            'currency' => 'RMB'
        ];
        $result = $orderInsert->orderInsert($data);
        $this->assertDatabaseHas('orders_rmb', $data);
    }

    public function test_myr_order_insert()
    {
        $orderInsert = new \App\Services\OrderInsert\OrderInsertMYR();
        $data = [
            'id' => 'A0000005',
            'name' => 'Melody Holiday Inn',
            'address' => json_encode([
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ]),
            'price' => '100',
            'currency' => 'MYR'
        ];
        $result = $orderInsert->orderInsert($data);
        $this->assertDatabaseHas('orders_myr', $data);
    }
    
    public function test_insert_order_failed()
    {
        // 測試失敗狀況
        $orderInsert = new \App\Services\OrderInsert\OrderInsertTWD();

        $data = [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => json_encode([
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ]),
            'price' => '2050',
            'currency' => 'USD'
        ];
        $result = $orderInsert->orderInsert($data);
        $this->assertDatabaseMissing('orders_twd', $data);

    }
    
    public function test_currency_of_factory_instance()
    {
        $currency = 'USD';
        $factory = new \App\Services\OrderInsert\OrderInsertFactory($currency);
        $orderInsert = $factory->create();
        $this->assertInstanceOf(\App\Services\OrderInsert\OrderInsertUSD::class, $orderInsert);

        $currency = 'TWD';
        $factory = new \App\Services\OrderInsert\OrderInsertFactory($currency);
        $orderInsert = $factory->create();
        $this->assertInstanceOf(\App\Services\OrderInsert\OrderInsertTWD::class, $orderInsert);

        $currency = 'RMB';
        $factory = new \App\Services\OrderInsert\OrderInsertFactory($currency);
        $orderInsert = $factory->create();
        $this->assertInstanceOf(\App\Services\OrderInsert\OrderInsertRMB::class, $orderInsert);

        $currency = 'MYR';
        $factory = new \App\Services\OrderInsert\OrderInsertFactory($currency);
        $orderInsert = $factory->create();
        $this->assertInstanceOf(\App\Services\OrderInsert\OrderInsertMYR::class, $orderInsert);

        $currency = 'JPY';
        $factory = new \App\Services\OrderInsert\OrderInsertFactory($currency);
        $orderInsert = $factory->create();
        $this->assertInstanceOf(\App\Services\OrderInsert\OrderInsertJPY::class, $orderInsert);

    }

    public function test_invalid_currency_of_factory_instance()
    {
        $this->expectException(\InvalidArgumentException::class);
        $currency = 'INVALID';
        $factory = new \App\Services\OrderInsert\OrderInsertFactory($currency);
        $orderInsert = $factory->create();
    }


    public function test_request_validation()
    {
        $request = new \App\Http\Requests\OrderRequest();
        $data = [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => '2050',
            'currency' => 'USD'
        ];
        $validator = Validator::make($data, $request->rules());
        $this->assertTrue($validator->passes());

    }


    public function test_missing_required_fields()
    {
        $request = new \App\Http\Requests\OrderRequest();
        $data = [
            // 缺少 'id' 和 'name'，以及 'price' 和 'currency'
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ]
        ];

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('id', $validator->errors()->messages());
        $this->assertArrayHasKey('name', $validator->errors()->messages());
        $this->assertArrayHasKey('price', $validator->errors()->messages());
        $this->assertArrayHasKey('currency', $validator->errors()->messages());
    }

    public function test_invalid_currency()
    {
        $request = new \App\Http\Requests\OrderRequest();
        $data = [
            'id' => 'A0000002',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => '2050',
            'currency' => 'INVALID_CURRENCY' // 無效的貨幣
        ];

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('currency', $validator->errors()->messages());
    }

    public function test_invalid_price_format()
    {
        $request = new \App\Http\Requests\OrderRequest();
        $data = [
            'id' => 'A0000003',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => 'invalid_price', // 非數字的價格
            'currency' => 'USD'
        ];

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('price', $validator->errors()->messages());
    }

    public function test_missing_address_subfields()
    {
        $request = new \App\Http\Requests\OrderRequest();
        $data = [
            'id' => 'A0000004',
            'name' => 'Melody Holiday Inn',
            'address' => [
                // 缺少 city, district, street
            ],
            'price' => '2050',
            'currency' => 'USD'
        ];

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('address.city', $validator->errors()->messages());
        $this->assertArrayHasKey('address.district', $validator->errors()->messages());
        $this->assertArrayHasKey('address.street', $validator->errors()->messages());
    }

    public function test_invalid_id_format()
    {
        $request = new \App\Http\Requests\OrderRequest();
        $data = [
            'id' => '', // 缺少 ID 或 ID 為空
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => '2050',
            'currency' => 'USD'
        ];

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('id', $validator->errors()->messages());
    }

    public function test_invalid_name_format()
    {
        $request = new \App\Http\Requests\OrderRequest();
        $data = [
            'id' => 'A0000005',
            'name' => '', // 名字為空
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => '2050',
            'currency' => 'USD'
        ];

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('name', $validator->errors()->messages());
    }

    public function test_controller_event_dispatched() {
        $valided = [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => '2050',
            'currency' => 'USD'
        ];
        Event::fake();
        $response = $this->postJson('/api/orders', $valided);
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Order created']);
        Event::assertDispatched(\App\Events\OrderCreatedEvent::class);
    }

    public function test_listener_dispatch_job() {
        Bus::fake();

        $valided = [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => '2050',
            'currency' => 'USD'
        ];
        Event::dispatch(new \App\Events\OrderCreatedEvent($valided));
        Bus::assertDispatched(\App\Jobs\OrderCreatedJob::class, function ($job) use ($valided) {
            return $job->data === $valided;
        });
    }

    public function test_job_handle() {
        $valided = [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => json_encode([
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ]),
            'price' => '2050',
            'currency' => 'USD'
        ];


        $job = new \App\Jobs\OrderCreatedJob($valided);
        $job->handle();
        $this->assertDatabaseHas('orders_usd', $valided);
    }
    

    
}
