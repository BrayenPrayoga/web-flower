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
        Schema::create('konfirmasi_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->integer('id_users')->nullable();
            $table->string('no_order', 30)->nullable();
            $table->string('bank_asal', 100)->nullable();
            $table->string('bank_tujuan', 100)->nullable();
            $table->string('metode', 50)->nullable();
            $table->decimal('nominal',12,2)->nullable();
            $table->dateTime('tanggal')->nullable();
            $table->text('bukti')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konfirmasi_pembayaran');
    }
};
