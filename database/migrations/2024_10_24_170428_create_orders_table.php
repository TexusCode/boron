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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('no');
            $table->string('user_id');
            $table->string('subtotal');
            $table->string('delivery_price')->nullable();
            $table->string('coupone_code')->nullable();
            $table->string('tax')->nullable();
            $table->string('discount')->nullable();
            $table->string('total');
            $table->string('city');
            $table->string('location');
            $table->string('payment');
            $table->string('delivery_type');
            $table->longText('note')->nullable();
            $table->string('status')->default('Неподтверждено');
            $table->integer('deliver_boy_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
