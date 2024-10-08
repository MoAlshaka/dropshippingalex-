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
            $table->string('shipment_status')->default('pending');
            $table->string('payment_status')->default('pending');
            $table->string('payment_type')->default('pending');
            $table->integer('calls')->nullable();
            $table->unsignedInteger('quantity');
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade')->onUpdate('cascade');;
            $table->foreignId('seller_id')->constrained('sellers')->onDelete('cascade')->onUpdate('cascade');;
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
