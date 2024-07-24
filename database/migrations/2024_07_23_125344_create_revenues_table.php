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
        Schema::create('revenues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('sellers')->onDelete('cascade')->onUpdate('cascade');;
            $table->foreignId('order_id')->constrained()->onDelete('cascade')->onUpdate('cascade');;
            $table->foreignId('lead_id')->constrained()->onDelete('cascade')->onUpdate('cascade');;
            $table->date('date');
            $table->decimal('revenue', 10, 2)->default(0)->nullable();
            $table->tinyInteger('is_received')->default(0)->nullable();
            $table->tinyInteger('is_confirmed')->default(0)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revenues');
    }
};
