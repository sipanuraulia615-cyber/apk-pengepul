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
        Schema::create('transaksi_jual', function (Blueprint $table) {
            $table->id('id_jual');
            $table->unsignedBigInteger('id_sayur');
            $table->unsignedBigInteger('id_petugas');
            $table->decimal('harga_per_kg', 12, 2);
            $table->decimal('jumlah_kg', 12, 2);
            $table->decimal('total_bayar', 14, 2);
            $table->dateTime('waktu_jual');

            $table->foreign('id_sayur')->references('id_sayur')->on('sayur');
            $table->foreign('id_petugas')->references('id_petugas')->on('petugas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_jual');
    }
};
