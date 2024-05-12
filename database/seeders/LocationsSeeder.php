<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            'Arusha', 'Dar es Salaam', 'Dodoma', 'Kagera', 'Kilimanjaro',
            'Mwanza', 
            
        ];

        foreach ($regions as $region) {
            Location::create([
                'name' => $region,
                
            ]);
        }
    }
}
