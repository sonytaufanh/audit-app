<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('business_unit_id')->nullable()->after('id')->constrained('business_units')->nullOnDelete();
            $table->string('nip', 20)->nullable()->after('name');
            $table->string('jabatan', 100)->nullable()->after('nip');
            $table->enum('role', ['superadmin', 'admin', 'audit_manager', 'auditor', 'risk_manager', 'risk_officer', 'user'])->default('user')->after('jabatan');
            $table->boolean('is_active')->default(true)->after('role');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['business_unit_id']);
            $table->dropColumn(['business_unit_id', 'nip', 'jabatan', 'role', 'is_active']);
        });
    }
};