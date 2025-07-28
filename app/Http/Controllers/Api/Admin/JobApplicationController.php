<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index(Request $request)
    {
        $applications = JobApplication::with(['user', 'job', 'company'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, function ($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(10);

        return response()->json($applications);
    }

    public function show($id)
    {
        $application = JobApplication::with(['user', 'job', 'company'])->findOrFail($id);
        return response()->json($application);
    }

    public function update(Request $request, $id)
    {
        $application = JobApplication::findOrFail($id);

        $application->status = $request->status ?? $application->status;
        $application->is_shortlisted = $request->is_shortlisted ?? $application->is_shortlisted;
        $application->note = $request->note ?? $application->note;
        $application->interview_date = $request->interview_date ?? $application->interview_date;
        $application->save();

        return response()->json([
            'message' => 'Cập nhật đơn ứng tuyển thành công!',
            'data' => $application
        ]);
    }
    public function destroy($id)
    {
        $application = JobApplication::findOrFail($id);
        $application->delete();

        return response()->json(['message' => 'Đơn ứng tuyển đã được xoá thành công!']);
    }
}

