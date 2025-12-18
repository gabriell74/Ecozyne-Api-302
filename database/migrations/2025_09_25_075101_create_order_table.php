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
            $table->foreign('community_id')
                ->references('id')
                ->on('community')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('waste_bank_id');
            $table->foreign('waste_bank_id')
                ->references('id')
                ->on('waste_bank')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('order_customer');
            $table->string('order_phone_number', 20);
            $table->text('order_address');
            $table->enum('status_order', ['pending', 'processed', 'delivered', 'cancelled', 'rejected']);
            $table->text('cancellation_reason')->nullable();
            $table->enum('status_payment', ['pending', 'paid', 'failed']);
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
