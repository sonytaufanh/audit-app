<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pelaksanaan_audits', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->foreignId('audit_plan_id')->nullable()->constrained('audit_plans')->nullOnDelete();
            $table->foreignId('audit_universe_id')->constrained('audit_universes');
            $table->foreignId('auditor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status', ['not_started', 'in_progress', 'completed', 'cancelled'])->default('not_started');
            $table->text('temuan_sementara')->nullable();
            $table->decimal('realisasi_anggaran', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelaksanaan_audits');
    }
};