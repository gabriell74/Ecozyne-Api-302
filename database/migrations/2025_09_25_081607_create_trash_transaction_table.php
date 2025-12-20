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
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->enum('status', ['rejected', 'pending', 'approved', 'completed'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->string('trash_image')->nullable();
            $table->integer('point_earned')->nullable();
            $table->integer('trash_weight')->nullable();
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
