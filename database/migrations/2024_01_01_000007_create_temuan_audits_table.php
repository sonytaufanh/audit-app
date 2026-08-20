<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('temuan_audits', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->foreignId('pelaksanaan_audit_id')->constrained('pelaksanaan_audits');
            $table->foreignId('departemen_id')->constrained('departemens');
            $table->string('judul', 200);
            $table->text('deskripsi');
            $table->enum('severity', ['low', 'medium', 'high', 'critical']);
            $table->enum('tipe', ['observasi', 'ketidaksesuaian', 'peluang_perbaikan', 'pelanggaran']);
            $table->text('rekomendasi')->nullable();
            $table->date('tanggal_temuan');
            $table->enum('status', ['open', 'in_progress', 'closed', 'overdue'])->default('open');
            $table->date('target_closure')->nullable();
            $table->date('actual_closure')->nullable();
            $table->text('root_cause')->nullable();
            $table->string('root_cause_category', 50)->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('temuan_audits');
    }
};