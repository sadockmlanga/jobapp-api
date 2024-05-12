<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications = Application::with('user','job')->get();
        return response()->json(['data' => $applications]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'resume' => 'required|file',
            'cover_letter' => 'required|string',
            'job_id' => 'required|exists:jobs,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $user = Auth::user();

        //only normal users can apply for job
        if(!$user->hasRole('user')){
            return response()->json(["message" => "Recruiters can not apply for Job"]);
        }

        // Check if the user has already applied for the job
        $existingApplication = Application::where('user_id', $user->id)
            ->where('job_id', $request->input('job_id'))
            ->exists();

        if ($existingApplication) {
            return response()->json(["message" => "You have already applied for this job"]);
        }

        $resumePath = $request->file('resume')->store('resumes');
    
        Application::create([
            'user_id' => $user->id,
            'resume' => $resumePath,
            'cover_letter' => $request->input('cover_letter'),
            'job_id' => $request->input('job_id'),
            'status' => 'applied'
        ]);

        // Increment the applications count for the job
        $job = Job::findOrFail($request->input('job_id'));
        $job->increment('applications');

        return response()->json(['message' => 'Application Sent Successful'], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $application = Application::with('user', 'job')->findOrFail($id);
        return response()->json(['data' => $application]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $application = Application::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => 'string',
            // 'resume' => 'file',
            // 'cover_letter' => 'sometimes|required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // if ($request->hasFile('resume')) {
        //     $resumePath = $request->file('resume')->store('resumes');
        //     $application->resume = $resumePath;
        // }
        // $application->cover_letter = $request->input('cover_letter');

        $application->status = $request->input('status');
        $application->save();
        

        return response()->json(['message' => 'Application updated', 'data' => $application]);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $application = Application::findOrFail($id);
        $application->delete();
        return response()->json(null, 204);
    }

    /**
     * List applied jobs per user
     */
    public function applied()
    {
        $applications = Application::with('job')->where('user_id', Auth::id())->get();

        if ($applications->isEmpty()) {
           return response()->json(['data' => 'No Job Application Yet']);
        }
          
        return response()->json(['data' => $applications]);
    }
    /**
     * List recruiter applications
     */
    public function showApplicationsForRecruiter($id)
    {
         // Retrieve applications for the specified recruiter
        $applications = Application::whereHas('job', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->with('user')->get();

        return response()->json(['data' => $applications]);
    }
    public function showMyApplicants()
    {
        $userId = Auth::id();
         // Retrieve applications for the recruiter
        $applications = Application::whereHas('job', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with('user','job')->get();

        return response()->json(['data' => $applications]);
    }
}
