<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rosters', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->decimal('shift_hours', 8, 2)->nullable();
            $table->enum('status', ['assigned','cancelled','complete','in-progress'])->default('assigned');
            $table->unsignedBigInteger('service_user_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedTinyInteger('travel_hours')->default(0);
            $table->unsignedTinyInteger('travel_minutes')->default(0);
            $table->unsignedBigInteger('assigned_by')->nullable();
            $table->unsignedBigInteger('cancelled_by')->nullable();
            $table->timestamps();

            $table->foreign('service_user_id')->references('id')->on('service_users')->cascadeOnDelete();
            $table->foreign('employee_id')->references('id')->on('employees')->cascadeOnDelete();
            $table->foreign('assigned_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('cancelled_by')->references('id')->on('users')->nullOnDelete();

            $table->index(['start', 'end']);
            $table->index(['employee_id', 'start']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rosters');
    }
};