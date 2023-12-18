<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('erasure_requests', function (Blueprint $table) {
            $table->id();
            $table->string('email_associated');
            $table->string('associated_phone')->nullable();
            $table->string('full_name');
            $table->text('address');
            $table->string('contact_telephone');
            $table->string('email_for_contact');
            $table->boolean('are_you_data_subject');
            $table->text('proof_of_identity');
            $table->text('proof_of_address');
            $table->string('data_subject_full_name')->nullable();
            $table->text('data_subject_address')->nullable();
            $table->string('data_subject_contact_telephone')->nullable();
            $table->string('data_subject_email_address')->nullable();
            $table->text('reason_for_erasure_request_text');
            $table->tinyInteger('reason_for_erasure_request_code')->unsigned();
            $table->text('information_to_erase_text');
            $table->boolean('read_and_understood_terms');
            $table->text('signature');
            $table->timestamp('timestamp_of_signing')->nullable();
            $table->text('authorization_from_data_subject')->nullable();
            $table->enum('request_status', ['New', 'In Review', 'Reviewed', 'Urgency', 'Processing', 'Follow Up', 'Waiting', 'Solved'])->default('New');
            $table->timestamp('timestamp_last_modification')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('erasure_requests');
    }
};
