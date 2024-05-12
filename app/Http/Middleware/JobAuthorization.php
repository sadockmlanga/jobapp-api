<?php

namespace App\Http\Middleware;

use App\Models\Job;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class JobAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $jobId = $request->route('id');
        $job = Job::findOrFail($jobId);
        $user = Auth::user();
        // dd($job->user_id);
       
        // Checking if the user is not an admin and is not the creator of the job
        if (!$user->isAdmin() && $job->user_id !== $user->id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

        return $next($request);
    }
}
