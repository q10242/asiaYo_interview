<?php
namespace App\Services\OrderInsert;

interface OrderInsert
{
    public function orderInsert(array $data): array;
}