<?php 
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create users
        $admin = User::create([
            'firstName' => 'Admin',
            'lastName' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('11111111'),
        ]);
      
        $recruiter1 = User::create([
            'firstName' => 'Recruiter',
            'lastName' => 'Vanguard',
            'userName' => 'van',
            'company' => 'Vandax',
            'email' => 'rec@rec.com',
            'password' => Hash::make('11111111'),
        ]);

        $recruiter2 = User::create([
            'firstName' => 'Vodacom',
            'lastName' => 'Limited',
            'userName' => 'Vodacom',
            'company' => 'Vodacom',
            'email' => 'voda@voda.com',
            'password' => Hash::make('11111111'),
        ]);
       
        $user1 = User::create([
            'firstName' => 'User',
            'lastName' => 'Master',
            'email' => 'user1@rec.com',
            'password' => Hash::make('11111111'),
        ]);

        $user2 = User::create([
            'firstName' => 'Andrea',
            'lastName' => 'mlisho',
            'email' => 'andrea@rec.com',
            'password' => Hash::make('11111111'),
        ]);

        // Assigning roles
        $adminRole = Role::create(['name' => 'admin']);
        $recruiterRole = Role::create(['name' => 'recruiter']);
        $userRole = Role::create(['name' => 'user']);

        $admin->assignRole($adminRole);
        $recruiter1->assignRole($recruiterRole);
        $recruiter2->assignRole($recruiterRole);
        $user1->assignRole($userRole);
        $user2->assignRole($userRole);
    }
}
