<?php

namespace App\Http\Controllers;

use App\Http\Middleware\JobAuthorization;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function __construct()
    {
        //ensures only the job creater / admin can update & delete
        $this->middleware(JobAuthorization::class)->only(['update', 'destroy', 'showApplications']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::with('location','category','user')->get();
        return response()->json(['data' => $jobs]);
    }

    public function recruiterJobsIndex()
    {
        //lists jobs created by spefic recruiter
        $jobs = Job::where('user_id', Auth::id())->with('category')->get();
        return response()->json([ 'data' => $jobs]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'location_id' => 'integer',
            'category_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $userID =  Auth::id();

        $job = Job::create([
            'user_id' => $userID,
            'title' => $request->title,
            'location_id' => $request->location_id,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ]);
        return response()->json(['message' => 'Job created', 'data' => $job], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $job = Job::findOrFail($id);
        return response()->json(['data' => $job]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            // 'location' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $job->update($request->all());
        return response()->json(['message' => 'Job updated', 'data' => $job]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();
        return response()->json(null, 204);
    }

    /**
     * Display applications for a specific job.
     */
    public function showApplications($id)
    {
        // dd($id);
        $job = Job::findOrFail($id);
        $applications = $job->applications;

        return response()->json(['data' => $applications]);
    }
}
