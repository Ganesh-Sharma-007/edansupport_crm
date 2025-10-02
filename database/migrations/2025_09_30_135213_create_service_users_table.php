<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_users', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50)->nullable();
            $table->string('title', 20)->nullable();
            $table->string('first_name');
            $table->string('middle_initial', 10)->nullable();
            $table->string('last_name');
            $table->string('preferred_name')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('marital_status', 30)->nullable();
            $table->string('ethnic_origin', 50)->nullable();
            $table->string('religion', 50)->nullable();
            $table->string('postcode', 20)->nullable();
            $table->date('start_date')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('service_priority', 50)->nullable();
            $table->string('branch', 100)->nullable();
            $table->decimal('care_hours', 8, 2)->nullable();
            $table->string('visit_duration', 50)->nullable();
            $table->string('type_of_service_user', 100)->nullable();
            $table->text('address')->nullable();
            $table->string('contact_number', 25)->nullable();
            $table->string('fax', 25)->nullable();
            $table->string('other', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_users');
    }
};