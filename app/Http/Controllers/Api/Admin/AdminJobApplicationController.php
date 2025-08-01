<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class AdminJobApplicationController extends Controller
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
        $request->validate([
        'status' => 'nullable|in:pending,viewed,under_review,rejected,contacting,interview_scheduled,interviewed,offered,hired,candidate_declined,no_response,saved',
        'is_shortlisted' => 'nullable|boolean',
        'note' => 'nullable|string',
        'interview_date' => 'nullable|date',
    ]);

    $application = JobApplication::findOrFail($id);

    $application->update([
        'status' => $request->status ?? $application->status,
        'is_shortlisted' => $request->is_shortlisted ?? $application->is_shortlisted,
        'note' => $request->note ?? $application->note,
        'interview_date' => $request->interview_date ?? $application->interview_date,
    ]);

    $application->load(['user', 'job', 'company']);

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

