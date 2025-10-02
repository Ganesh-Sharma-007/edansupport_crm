<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // nothing to insert here – roles are just strings in users.role
        // (super-admin, admin, employee)
        // kept for future expansion if you want a dedicated roles table
    }
}