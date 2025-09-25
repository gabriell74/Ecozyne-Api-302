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
        Schema::create('gift', function (Blueprint $table) {
            $table->id();
            $table->string('gift_name');
            $table->string('description');
            $table->string('photo');
            $table->integer('stock');
            $table->integer('unit_point');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift');
    }
};
