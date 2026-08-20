<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('budget_coas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_coa', 20)->unique();
            $table->string('nama', 200);
            $table->enum('tipe', ['pendapatan', 'beban', 'aset', 'kewajiban', 'ekuitas']);
            $table->foreignId('departemen_id')->nullable()->constrained('departemens')->nullOnDelete();
            $table->decimal('anggaran', 15, 2)->default(0);
            $table->decimal('realisasi', 15, 2)->default(0);
            $table->year('tahun');
            $table->enum('periode', ['Q1', 'Q2', 'Q3', 'Q4', 'Tahunan']);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('budget_coas');
    }
};