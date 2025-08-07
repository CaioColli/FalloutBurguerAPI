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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                ->constrained(
                    table: 'products',
                    indexName: 'product_id'
                )
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('ingredient_id')
                ->constrained(
                    table: 'stock',
                    indexName: 'ingredient_id'
                )
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_products');
    }
};
