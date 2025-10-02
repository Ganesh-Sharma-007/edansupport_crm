<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('title', 20)->nullable();
            $table->string('first_name');
            $table->string('middle_initial', 10)->nullable();
            $table->string('last_name');
            $table->date('date_of_birth')->nullable();
            $table->date('start_date')->nullable();
            $table->date('date_of_termination')->nullable();
            $table->string('preferred_name')->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('postcode', 20)->nullable();
            $table->string('branch', 100)->nullable();
            $table->string('area', 100)->nullable();
            $table->string('house_no', 50)->nullable();
            $table->string('mobile_no', 25)->nullable();
            $table->decimal('contracted_hours', 8, 2)->nullable();
            $table->string('tax_code', 20)->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('marital_status', 30)->nullable();
            $table->string('nationality', 50)->nullable();
            $table->string('ethnic_origin', 50)->nullable();
            $table->string('religion', 50)->nullable();
            $table->boolean('is_salaried')->default(false);
            $table->boolean('enforce_hours')->default(false);
            $table->string('national_insurance', 30)->nullable();
            $table->tinyInteger('days_per_week')->nullable();
            $table->decimal('hours_of_week', 8, 2)->nullable();
            $table->string('drive_status', 30)->nullable(); // driver / non-driver
            $table->date('estimate_hour_pay_date')->nullable();
            $table->string('dbs_in_place', 50)->nullable();
            $table->text('medical_issue')->nullable();
            $table->boolean('disability')->default(false);
            $table->string('next_of_kin_name')->nullable();
            $table->text('home_address')->nullable();
            $table->string('emergency_contact_no', 25)->nullable();
            $table->string('emergency_contact_email', 100)->nullable();
            $table->string('consent_status', 50)->nullable();
            $table->date('consent_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};