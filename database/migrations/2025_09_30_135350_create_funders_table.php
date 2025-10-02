<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('funders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('middle_initial', 10)->nullable();
            $table->string('last_name')->nullable();
            $table->string('preferred_name')->nullable();
            $table->string('type', 50)->nullable(); // private, public, etc.
            $table->text('address')->nullable();
            $table->string('city_town', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('postcode', 20)->nullable();
            $table->date('start_date')->nullable();
            $table->string('branch', 100)->nullable();
            $table->string('mobile', 25)->nullable();
            $table->string('email', 100)->nullable();
            $table->text('notes')->nullable();
            $table->string('fax', 25)->nullable();
            $table->string('other', 255)->nullable();
            $table->string('website', 255)->nullable();
            $table->boolean('purchase_order_required')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('funders');
    }
};