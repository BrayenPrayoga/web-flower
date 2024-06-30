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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->integer('id_users')->nullable();
            $table->string('no_order', 30)->nullable();
            $table->integer('status_transaksi')->nullable();
            $table->dateTime('tanggal_transaksi')->nullable();
            $table->decimal('total_harga_transaksi',12,2)->nullable();
            $table->integer('id_kupon')->nullable();
            $table->text('alamat')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
