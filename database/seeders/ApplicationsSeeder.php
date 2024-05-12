<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\Job;
use App\Models\User;

class ApplicationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get job IDs
        $jobs = Job::pluck('id');

        // Get user IDs
        $users = User::role('user')->pluck('id');

        // Create 10 random applications
        for ($i = 0; $i < 10; $i++) {
            Application::create([
                'job_id' => $jobs->random(),
                'user_id' => $users->random(),
                'resume' => 'public/resumes' . 'demoResume.pdf', 
                'cover_letter' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 
                'status' => 'applied', 
            ]);
        
    }

}
}
