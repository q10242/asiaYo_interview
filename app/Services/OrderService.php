<?php
namespace App\Services;
use App\Services\OrderInsert\OrderInsertFactory;

class OrderService
{
    public function orderInsert(array $data, string $currency): array
    {
        $orderInsert = new OrderInsertFactory();
        $orderInsert = $orderInsert->create($currency);
        return $orderInsert->orderInsert($data);
    }
}