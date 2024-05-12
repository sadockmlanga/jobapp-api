<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LocationsSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(JobSeeder::class);
        $this->call(ApplicationsSeeder::class);
    }
}
