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
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('store_name')->unique();
            $table->string('store_phone')->unique();
            $table->longText('description')->nullable();
            $table->longText('logo')->nullable();
            $table->longText('patent')->nullable();
            $table->longText('passport_front')->nullable();
            $table->longText('passport_back')->nullable();
            $table->boolean('moy_sklad')->default(false);
            $table->longText('moysklad_login')->nullable();
            $table->longText('moysklad_password')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('isverified')->default(false);
            $table->date('register_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
