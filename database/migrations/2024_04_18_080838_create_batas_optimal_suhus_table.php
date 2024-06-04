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
        Schema::create('batas_optimal_suhus', function (Blueprint $table) {
            $table->id();
            $table->float('Suhu_Minimal');
            $table->float('Suhu_Maximal');

            $table->unsignedBigInteger('Jenis_ikan_ID')->nullable();
            $table->foreign('Jenis_ikan_ID')->references('id')->on('jenis_ikans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batas_optimal_suhus');
    }
};
