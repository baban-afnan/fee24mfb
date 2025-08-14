<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bvn_modification', function (Blueprint $table) {
            $table->string('bank')->nullable()->after('service_name');
        });
    }

    public function down(): void
    {
        Schema::table('bvn_modification', function (Blueprint $table) {
            $table->dropColumn(['service_name', 'bank', 'modification_field_name']);
        });
    }
};
