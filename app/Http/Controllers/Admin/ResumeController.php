<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use PHPUnit\Framework\Constraint\IsFalse;
use Illuminate\Support\Facades\DB;



class ResumeController extends Controller
{

    public function index()
    {
        $title = 'Admin duyệt hồ sơ ứng viên';
        return view('admin.resumes.index',compact('title'));
    }

}