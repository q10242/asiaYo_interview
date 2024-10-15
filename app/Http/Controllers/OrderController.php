<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\DB;
use App\Services\OrderInsert\OrderInsertFactory;
use App\Events\OrderCreatedEvent;

class OrderController extends Controller
{
    public function store(OrderRequest $request)
    {
        if(is_array($request->address)) {
            $request->merge(['address' =>json_encode( $request->address)]);
        }
        OrderCreatedEvent::dispatch($request->all());
        return response()->json(['message' => 'Order created'], 200);
    }


    public function show($id)
    {
        $query = DB::table('orders_twd')->where('id',$id)
            ->union(DB::table('orders_jpy'))->where('id', $id)
            ->union(DB::table('orders_usd'))->where('id', $id)
            ->union(DB::table('orders_rmb'))->where('id', $id)
            ->union(DB::table('orders_myr'))->where('id', $id)
            ->first();
        if(!$query) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        $query->address = json_decode($query->address);
        // return json 
        return response()->json($query);
    }
}
