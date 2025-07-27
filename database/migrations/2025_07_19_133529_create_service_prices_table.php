<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('service_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->foreignId('modification_field_id')->nullable()->constrained('modification_fields')->onDelete('cascade');
            $table->enum('user_type', ['user', 'agent', 'admin']);
            $table->decimal('price', 10, 2);
            $table->timestamps();
            
            $table->unique(['service_id', 'modification_field_id', 'user_type'], 'service_prices_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_prices');
    }
};
