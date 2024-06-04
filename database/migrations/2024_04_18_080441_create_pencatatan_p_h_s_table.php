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
        Schema::create('pencatatan_p_h_s', function (Blueprint $table) {
            $table->id();
            $table->float('pH_Kolam');
            $table->date('Tanggal_Monitoring');

            $table->unsignedBigInteger('Batas_optimal_pH_ID')->nullable();
            $table->foreign('Batas_optimal_pH_ID')->references('id')->on('batas_optimal_p_h_s');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pencatatan_p_h_s');
    }
};
