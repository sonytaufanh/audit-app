<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('risk_monitorings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risk_register_id')->constrained('risk_registers');
            $table->date('tanggal');
            $table->integer('impact_score');
            $table->integer('probability_score');
            $table->integer('risk_score');
            $table->enum('risk_level', ['low', 'medium', 'high', 'critical']);
            $table->text('catatan')->nullable();
            $table->text('tindakan')->nullable();
            $table->foreignId('reported_by')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('risk_monitorings');
    }
};