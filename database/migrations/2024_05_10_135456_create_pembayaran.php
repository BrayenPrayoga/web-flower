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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->integer('id_users')->nullable();
            $table->string('no_order')->nullable();
            $table->string('bank_asal')->nullable();
            $table->string('bank_tujuan')->nullable();
            $table->string('metode')->nullable();
            $table->string('nominal')->nullable();
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
        Schema::dropIfExists('pembayaran');
    }
};