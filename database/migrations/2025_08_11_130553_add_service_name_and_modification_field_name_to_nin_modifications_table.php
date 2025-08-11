<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('nin_modifications', function (Blueprint $table) {
        $table->string('service_name')->nullable()->after('service_id');
        $table->string('modification_field_name')->nullable()->after('modification_field_id');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nin_modifications', function (Blueprint $table) {
            //
        });
    }
};
