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
        Schema::create('exchange_transaction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exchange_id');
            $table->foreign('exchange_id')->references('id')->on('exchange')->onDelete('cascade');
            $table->unsignedBigInteger('gift_id');
            $table->foreign('gift_id')->references('id')->on('gift')->onDelete('cascade');
            $table->integer('amount');
            $table->integer('unit_point');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_transaction');
    }
};
