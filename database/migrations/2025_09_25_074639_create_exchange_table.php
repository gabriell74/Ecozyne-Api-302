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
        Schema::create('exchange', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('community_id');
            $table->foreign('community_id')
                ->references('id')
                ->on('community')
                ->onDelate('cascade')
                ->onUpdate('cascade');
            $table->string('exchange_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange');
    }
};
