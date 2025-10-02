<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique();
            $table->unsignedBigInteger('service_user_id');
            $table->unsignedBigInteger('funder_id')->nullable();
            $table->date('issue_date');
            $table->date('due_date');
            $table->enum('status', ['draft','published'])->default('draft');
            $table->decimal('total_amount', 10, 2);
            $table->unsignedBigInteger('generated_by');
            $table->timestamps();

            $table->foreign('service_user_id')->references('id')->on('service_users')->cascadeOnDelete();
            $table->foreign('funder_id')->references('id')->on('funders')->nullOnDelete();
            $table->foreign('generated_by')->references('id')->on('users')->cascadeOnDelete();

            $table->index(['status', 'due_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};