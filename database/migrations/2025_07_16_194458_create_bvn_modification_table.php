<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bvn_modification', function (Blueprint $table) {
          $table->id();
          $table->string('reference')->unique();
          $table->foreignId('user_id')->constrained();
          $table->foreignId('modification_field_id')->constrained('modification_fields');
          $table->foreignId('service_id')->constrained('services');
          $table->string('bvn', 50);
          $table->string('nin', 50);
          $table->string('description', 150);
          $table->string('affidavit', 50);
          $table->string('affidavit_file')->nullable();
          $table->string('affidavit_file_url')->nullable();
          $table->foreignId('transaction_id')->constrained();
          $table->dateTime('submission_date');
          $table->string('status')->default('pending');
          $table->text('comment')->nullable();
          $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bvn_modification');
    }
};
