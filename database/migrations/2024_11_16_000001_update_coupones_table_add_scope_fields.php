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
        Schema::table('coupones', function (Blueprint $table) {
            $table->string('scope')->default('all')->after('percent');
            $table->foreignId('category_id')->nullable()->after('scope')->constrained()->nullOnDelete();
            $table->boolean('auto_apply')->default(false)->after('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupones', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['scope', 'category_id', 'auto_apply']);
        });
    }
};
