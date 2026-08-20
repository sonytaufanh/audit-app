<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('risk_registers', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('nama', 200);
            $table->text('deskripsi');
            $table->foreignId('departemen_id')->constrained('departemens');
            $table->foreignId('kategori_risiko_id')->constrained('kategori_risikos');
            $table->integer('impact_score');
            $table->integer('probability_score');
            $table->integer('risk_score');
            $table->enum('risk_level', ['low', 'medium', 'high', 'critical']);
            $table->text('penyebab')->nullable();
            $table->text('dampak')->nullable();
            $table->text('mitigasi')->nullable();
            $table->enum('status', ['identified', 'assessed', 'treated', 'monitored', 'closed'])->default('identified');
            $table->foreignId('risk_owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('tanggal_identifikasi');
            $table->date('tanggal_review')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('risk_registers');
    }
};