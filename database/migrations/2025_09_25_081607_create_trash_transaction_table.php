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
        Schema::create('trash_transaction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('waste_bank_id');
            $table->foreign('waste_bank_id')
                ->references('id')
                ->on('waste_bank')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('poin_earned');
            $table->integer('trash_weight');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trash_transaction');
    }
};
