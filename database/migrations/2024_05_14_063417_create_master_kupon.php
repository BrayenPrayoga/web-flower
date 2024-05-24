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
        Schema::create('master_kupon', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50)->nullable();
            $table->string('kode', 20)->nullable();
            $table->decimal('kredit',12,2)->nullable();
            $table->dateTime('tanggal_mulai')->nullable();
            $table->dateTime('tanggal_berakhir')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_kupon');
    }
};
