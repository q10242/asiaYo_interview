<?php
namespace App\Services\OrderInsert;
use App\Services\OrderInsert\OrderInsertTWD;
use App\Services\OrderInsert\OrderInsertUSD;
use App\Services\OrderInsert\OrderInsertRMB;
use App\Services\OrderInsert\OrderInsertMYR;
use App\Services\OrderInsert\OrderInsertJPY;

class OrderInsertFactory {

    public static function create(string $currency): OrderInsert
    {
        switch ($currency) {
            case 'TWD':
                return new OrderInsertTWD();
            case 'USD':
                return new OrderInsertUSD();
            case 'RMB':
                return new OrderInsertRMB();
            case 'MYR':
                return new OrderInsertMYR();
            case 'JPY':
                return new OrderInsertJPY();
            default:
                throw new \InvalidArgumentException('Invalid currency');
        }
    }
}