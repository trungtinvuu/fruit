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
        Schema::getConnection()->statement("
            CREATE VIEW products_view AS
            SELECT products.*, categories.name AS category
            FROM products
            JOIN categories ON products.category_id = categories.id;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::getConnection()->statement("DROP VIEW IF EXISTS products_view");
    }
};
