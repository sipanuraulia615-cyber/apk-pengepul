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
        Schema::create('chatbot', function (Blueprint $table) {
            $table->id('id_log');
            $table->unsignedBigInteger('id_pemilik');
            $table->text('perintah_teks');
            $table->text('hasil_respon');
            $table->dateTime('waktu_percakapan');

            $table->foreign('id_pemilik')->references('id_pemilik')->on('pemilik')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot');
    }
};
