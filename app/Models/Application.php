<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Application extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['resume_url'];

    public function getResumeUrlAttribute()
    {
        return Storage::url('public/resumes/' . $this->resume);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
