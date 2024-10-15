<?php
namespace App\Services\OrderInsert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class OrderInsertTWD implements OrderInsert
{
    public function orderInsert(array $data): array
    {        
        if(Str::upper($data['currency']) !== 'TWD') {
            return [
                'message' => 'Currency is not TWD'
            ];
        }
        DB::table('orders_twd')->insert($data);
        return [
            'message' => 'Order created in TWD',
            'data' => $data
        ];
    }
}