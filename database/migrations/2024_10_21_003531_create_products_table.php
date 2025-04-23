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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('seller_id');
            $table->longText('moysklad_id')->nullable();
            $table->longText('name');
            $table->longText('description')->nullable();
            $table->longText('code')->nullable();
            $table->integer('stock')->nullable();
            $table->longText('price')->nullable();
            $table->longText('discount')->nullable();
            $table->longText('delivery')->nullable();
            $table->longText('miniature')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('subcategory_id')->nullable();
            $table->integer('sell')->default(0);
            $table->boolean('istop')->default(false);
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
