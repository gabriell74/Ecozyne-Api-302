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
        Schema::create('eco_enzyme_trackings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('waste_bank_id');
            $table->string('batch_name');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('notes')->nullable()->default('Tidak ada Catatan');
            $table->timestamps();

            $table->foreign('waste_bank_id')
                ->references('id')->on('waste_bank')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
