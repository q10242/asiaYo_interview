<?php
namespace App\Services\OrderInsert;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class OrderInsertUSD implements OrderInsert
{
    public function orderInsert(array $data): array
    {
        if(Str::upper($data['currency']) !== 'USD') {
            return [
                'message' => 'Currency is not USD'
            ];
        }
        DB::table('orders_usd')->insert($data);
        return [
            'message' => 'Order created in USD',
            'data' => $data
        ];
    }
}