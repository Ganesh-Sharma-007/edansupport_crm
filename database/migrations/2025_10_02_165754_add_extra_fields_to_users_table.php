<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->after('id');
            $table->string('title', 20)->nullable()->after('username');
            $table->string('first_name')->nullable()->after('title');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('gender', 20)->nullable()->after('last_name');
            $table->string('support_worker_type', 50)->nullable()->after('gender');
            $table->string('address_line_1')->nullable()->after('avatar');
            $table->string('address_line_2')->nullable()->after('address_line_1');
            $table->string('city')->nullable()->after('address_line_2');
            $table->string('postcode', 20)->nullable()->after('city');
            $table->string('branch')->nullable()->after('postcode');
            $table->decimal('latitude', 10, 7)->nullable()->after('branch');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            $table->string('pin', 20)->nullable()->after('phone');
            $table->string('team')->nullable()->after('pin');
            $table->boolean('is_shared')->default(false)->after('team');
            $table->boolean('is_active')->default(true)->after('is_shared');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username','title','first_name','last_name','gender','support_worker_type',
                'address_line_1','address_line_2','city','postcode','branch',
                'latitude','longitude','pin','team','is_shared','is_active'
            ]);
        });
    }
};
