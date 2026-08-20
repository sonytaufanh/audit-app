<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE risk_monitorings ALTER COLUMN reported_by DROP NOT NULL");
    }

    public function down()
    {
        DB::statement("UPDATE risk_monitorings SET reported_by = 1 WHERE reported_by IS NULL");
        DB::statement("ALTER TABLE risk_monitorings ALTER COLUMN reported_by SET NOT NULL");
    }
};
