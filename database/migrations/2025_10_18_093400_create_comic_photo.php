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
        Schema::create('comic_photo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comic_id');
            $table->foreign('comic_id')
                ->references('id')
                ->on('comic')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('photo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comic_photo');
    }
};
