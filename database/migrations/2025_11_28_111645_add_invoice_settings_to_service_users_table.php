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
        Schema::table('service_users', function (Blueprint $table) {
            $table->string('funder_type')->nullable();
            $table->foreignId('funder_id')->nullable()->constrained('funders');
            $table->decimal('care_price', 8, 2)->nullable();
            $table->integer('travel_time')->nullable(); // in minutes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_users', function (Blueprint $table) {
            //
        });
    }
};
