<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('audit_universes', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('nama', 200);
            $table->text('deskripsi')->nullable();
            $table->foreignId('departemen_id')->constrained('departemens');
            $table->enum('tipe', ['operasional', 'keuangan', 'kepatuhan', 'teknologi_informasi', 'strategis']);
            $table->enum('risk_level', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->date('last_audit_date')->nullable();
            $table->integer('audit_frequency_months')->default(12);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('audit_universes');
    }
};