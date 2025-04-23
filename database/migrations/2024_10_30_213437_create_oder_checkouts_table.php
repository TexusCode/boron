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
        Schema::create('oder_checkouts', function (Blueprint $table) {
            $table->id();
            $table->string('cookie');
            $table->string('subtotal');
            $table->string('delivery_price')->nullable();
            $table->string('coupone_code')->nullable();
            $table->string('tax')->nullable();
            $table->string('discount')->nullable();
            $table->string('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oder_checkouts');
    }
};
