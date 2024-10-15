<?php
namespace App\Services\OrderInsert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class OrderInsertMYR implements OrderInsert
{
    public function orderInsert(array $data): array
    {
        if(Str::upper($data['currency']) !== 'MYR') {
            return [
                'message' => 'Currency is not MYR'
            ];
        }
        DB::table('orders_myr')->insert($data);
        return [
            'message' => 'Order created in MYR',
            'data' => $data
        ];
    }
}