<?php
namespace App\Services\OrderInsert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderInsertRMB implements OrderInsert
{
    public function orderInsert(array $data): array
    {
        if(Str::upper($data['currency']) !== 'RMB') {
            return [
                'message' => 'Currency is not RMB'
            ];
        }
        DB::table('orders_rmb')->insert($data);
        return [
            'message' => 'Order created in RMB',
            'data' => $data
        ];
    }
}