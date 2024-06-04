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
        Schema::create('batas_optimal_p_h_s', function (Blueprint $table) {
            $table->id();
            $table->float('pH_Minimal');
            $table->float('pH_Maximal');

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
        Schema::dropIfExists('batas_optimal_p_h_s');
    }
};
