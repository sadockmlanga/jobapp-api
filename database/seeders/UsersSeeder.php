<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run(): void
    {
        User::create([
            'firstName' => 'Admin',
            'lastName' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('11111111'),
        ]);
      
        User::create([
            'firstName' => 'Recruiter',
            'lastName' => 'Vanguard',
            'email' => 'rec@rec.com',
            'password' => Hash::make('11111111'),
        ]);
       
        User::create([
            'firstName' => 'User',
            'lastName' => 'Master',
            'email' => 'user@rec.com',
            'password' => Hash::make('11111111'),
        ]);

        User::create(['name' => 'user']);
        User::create(['name' => 'recruiter']);
    }
}
