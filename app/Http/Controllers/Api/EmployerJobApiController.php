<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;

class EmployerJobApiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $company = $user->company;

        if (!$company) {
            return response()->json([], 200);
        }

        $jobs = Job::where('company_id', $company->id)->latest()->get();

        return response()->json($jobs);
    }
}
