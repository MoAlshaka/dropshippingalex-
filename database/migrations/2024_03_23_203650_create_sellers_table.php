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
            $table->string('email')->unique();
            $table->string('password');
            $table->string('national_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone', 20);
            $table->string('address')->nullable();
            $table->text('about_us')->nullable();
            $table->string('image')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('account')->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->foreignId('admin_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
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
