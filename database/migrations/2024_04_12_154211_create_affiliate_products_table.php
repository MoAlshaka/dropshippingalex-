<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('affiliate_products', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->string('title');
            $table->text('description');
            $table->string('image');
            $table->string('brand');
            $table->double('weight')->default(0);
            $table->double('minimum_selling_price')->default(0);
            $table->double('comission')->default(0);
            $table->string('type');
            $table->foreignId('category_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_products');
    }
};
