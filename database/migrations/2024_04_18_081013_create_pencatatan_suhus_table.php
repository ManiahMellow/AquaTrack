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
        Schema::create('pencatatan_suhus', function (Blueprint $table) {
            $table->id();
            $table->float('suhu_Kolam');
            $table->date('Tanggal_Monitoring');

            $table->unsignedBigInteger('Batas_optimal_suhu_ID')->nullable();
            $table->foreign('Batas_optimal_suhu_ID')->references('id')->on('batas_optimal_suhus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pencatatan_suhus');
    }
};
