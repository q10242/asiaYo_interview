<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        $currencyTypes = ['twd', 'usd', 'jpy', 'rmb', 'myr'];

        foreach ($currencyTypes as $currencyType) {
            Schema::create('orders_' . $currencyType, function (Blueprint $table) {
                $table->string('id')->primary();
                $table->string('name');
                $table->json(column: 'address');
                $table->integer('price');
                $table->string('currency');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
