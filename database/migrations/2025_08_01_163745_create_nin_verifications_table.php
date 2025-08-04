<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNinVerificationsTable extends Migration
{
    public function up()
    {
        Schema::create('nin_verifications', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('modification_field_id')->constrained('modification_fields');
            $table->foreignId('service_id')->constrained('services');
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('surname')->nullable();
            $table->string('gender')->nullable();
            $table->string('birthdate')->nullable();
            $table->string('birthstate')->nullable();
            $table->string('birthlga')->nullable();
            $table->string('birthcountry')->nullable();
            $table->string('maritalstatus')->nullable();
            $table->string('email')->nullable();
            $table->string('telephoneno')->nullable();
            $table->string('residence_address')->nullable();
            $table->string('residence_state')->nullable();
            $table->string('residence_lga')->nullable();
            $table->string('residence_town')->nullable();
            $table->string('religion')->nullable();
            $table->string('employmentstatus')->nullable();
            $table->string('educationallevel')->nullable();
            $table->string('profession')->nullable();
            $table->string('heigth')->nullable();
            $table->string('title')->nullable();
            $table->string('number_nin')->nullable();
            $table->string('vnin')->nullable();
            $table->longText('photo_path')->nullable();
            $table->longText('signature_path')->nullable();
            $table->string('trackingId')->nullable();
            $table->string('userid')->nullable();

            // Next of Kin
            $table->string('nok_firstname')->nullable();
            $table->string('nok_middlename')->nullable();
            $table->string('nok_surname')->nullable();
            $table->string('nok_address1')->nullable();
            $table->string('nok_address2')->nullable();
            $table->string('nok_lga')->nullable();
            $table->string('nok_state')->nullable();
            $table->string('nok_town')->nullable();
            $table->string('nok_postalcode')->nullable();

            // Self-origin info
            $table->string('self_origin_state')->nullable();
            $table->string('self_origin_lga')->nullable();
            $table->string('self_origin_place')->nullable();
            $table->foreignId('transaction_id')->constrained();
            $table->enum('status', ['pending', 'processing', 'resolved', 'rejected', 'query', 'remark'])->default('pending');
            $table->dateTime('submission_date');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nin_verifications');
    }
}