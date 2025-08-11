<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bvn_modification', function (Blueprint $table) {
            $table->string('service_name')->nullable()->after('service_id');
            $table->string('modification_field_name')->nullable()->after('modification_field_id');
        });
    }

    public function down()
    {
        Schema::table('bvn_modification', function (Blueprint $table) {
            $table->dropColumn(['service_name', 'modification_field_name']);
        });
    }
};
