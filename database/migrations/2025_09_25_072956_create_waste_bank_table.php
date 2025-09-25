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
        Schema::create('waste_bank', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('waste_bank_submission_id');
            $table->foreign('waste_bank_submission_id')->references('id')->on('waste_bank_submission')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_bank');
    }
};
