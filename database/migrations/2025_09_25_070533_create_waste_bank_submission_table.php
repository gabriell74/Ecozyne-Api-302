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
        Schema::create('waste_bank_submission', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('community_id');
            $table->foreign('community_id')
                ->references('id')
                ->on('community')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('waste_bank_name');
            $table->string('waste_bank_location');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('file_document');
            $table->string('notes');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_bank_submission');
    }
};
