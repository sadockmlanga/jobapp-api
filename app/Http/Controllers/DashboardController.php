<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function getCounts()
    {
        $usersCount = $this->getUsersCount('user');
        $recruitersCount = $this->getUsersCount('recruiter');
        $jobsCount = Job::count();
        $applicationsCount = Application::count();

        return response()->json([
            'usersCount' => $usersCount,
            'recruitersCount' => $recruitersCount,
            'jobsCount' => $jobsCount,
            'applicationsCount' => $applicationsCount,
        ]);
    }

    public function getRecruiters()
    {
        $recruiters = $this->getUsersByRole('recruiter');
        return response()->json(["data" => $recruiters]);
    }

    public function getUsers()
    {
        $users = $this->getUsersByRole('user');
        return response()->json(["data" => $users]);
    }

    private function getUsersCount($roleName)
    {
        $role = Role::where('name', $roleName)->first();
        return $role ? $role->users->count() : 0;
    }

    private function getUsersByRole($roleName)
    {
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            return response()->json(['message' => ucfirst($roleName) . ' role not found'], 404);
        }

        return $role->users;
    }
}
