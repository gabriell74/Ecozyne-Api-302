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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('community_id');
            $table->foreign('community_id')->references('id')->on('community')->onDelete('cascade');
            $table->unsignedBigInteger('waste_bank_id');
            $table->foreign('waste_bank_id')->references('id')->on('waste_bank')->onDelete('cascade');
            $table->string('status_order');
            $table->string('status_payment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
