<?php
namespace App\Services\OrderInsert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class OrderInsertJPY implements OrderInsert
{
    public function orderInsert(array $data): array
    {
        if(Str::upper($data['currency'])  !== 'JPY') {
            return [
                'message' => 'Currency is not JPY'
            ];
        }
        DB::table('orders_jpy')->insert($data);
        return [
            'message' => 'Order created in JPY',
            'data' => $data
        ];
    }
}