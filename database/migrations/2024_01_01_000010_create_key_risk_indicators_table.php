<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('key_risk_indicators', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('nama', 200);
            $table->text('deskripsi')->nullable();
            $table->foreignId('risk_register_id')->nullable()->constrained('risk_registers')->nullOnDelete();
            $table->foreignId('departemen_id')->constrained('departemens');
            $table->decimal('target', 10, 2);
            $table->decimal('current_value', 10, 2);
            $table->decimal('threshold_min', 10, 2)->nullable();
            $table->decimal('threshold_max', 10, 2)->nullable();
            $table->string('satuan', 20)->nullable();
            $table->enum('status', ['green', 'yellow', 'red'])->default('green');
            $table->enum('frekuensi', ['harian', 'mingguan', 'bulanan', 'triwulan', 'semesteran', 'tahunan']);
            $table->date('last_update');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('key_risk_indicators');
    }
};