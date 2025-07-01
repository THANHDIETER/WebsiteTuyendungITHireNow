<?php
namespace App\Http\Controllers\Employers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function index()
    {
        return view('employer.index');
    }
}