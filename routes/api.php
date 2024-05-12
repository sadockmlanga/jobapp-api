<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UsersConntroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;









/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/jobs', [JobController::class, 'index']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/location', [LocationController::class,  'index']);

Route::middleware('auth:sanctum')->group( function () {
    Route::group(['prefix' => 'jobs'], function () {
        Route::post('/', [JobController::class, 'store']);
        Route::get('/{id}', [JobController::class, 'show']);
        Route::put('/{id}', [JobController::class, 'update']);
        Route::delete('/{id}', [JobController::class, 'destroy']);
        Route::get('/app/{id}', [JobController::class, 'showApplications']);
    });
    Route::get('/recruiter-jobs', [JobController::class, 'recruiterJobsIndex']);

    Route::group(['prefix' => 'applications'], function () {
        Route::get('/', [ApplicationController::class, 'index']);
        Route::post('/', [ApplicationController::class, 'store']);
        Route::get('/{id}', [ApplicationController::class, 'show']);
        Route::post('/{id}', [ApplicationController::class, 'update']);
        Route::delete('/{id}', [ApplicationController::class, 'destroy']);
        Route::get('/rec/{id}', [ApplicationController::class, 'showApplicationsForRecruiter']);
    });
    Route::get('/recruiter-applications', [ApplicationController::class, 'showMyApplicants']);
    Route::get('/applied', [ApplicationController::class, 'applied']); 
    
    Route::group(['prefix' => 'admin/dash'], function () {
        Route::get('/counts', [DashboardController::class, 'getCounts']);
        Route::get('/recruiters', [DashboardController::class, 'getRecruiters']);
        Route::get('/users', [DashboardController::class, 'getUsers']);
    });
});
Route::get('user-details/{id}', [UsersConntroller::class, 'show']);

Route::get('/getSession', [StripeController::class, 'createCheckoutSession']);
Route::post('/stripe/webhook', [StripeController::class, 'handleWebhook']);