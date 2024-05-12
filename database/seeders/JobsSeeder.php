<?php

use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\User;
use App\Models\Category;
use App\Models\Location;

class JobsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get user IDs for recruiters
        $recruiters = User::role('recruiter')->pluck('id');

        // Get category IDs
        $categories = Category::pluck('id');

        // Get location IDs
        $locations = Location::pluck('id');

        // Create 10 jobs
        for ($i = 0; $i < 10; $i++) {
            Job::create([
                'user_id' => $recruiters->random(),
                'category_id' => $categories->random(),
                'location_id' => $locations->random(),
                'title' => 'Job Title ' . ($i + 1), // Random title
                'description' => $this->generateRandomDescription(), // Random description
                // 'applications' => rand(0, 100), // Random number of applications
            ]);
        }
    }

    /**
     * Generate a random description for a job.
     *
     * @return string
     */
    private function generateRandomDescription()
    {
        $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. ';
        $description .= 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ';
        $description .= 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ';
        $description .= 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. ';
        $description .= 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

        return $description;
    }
}
