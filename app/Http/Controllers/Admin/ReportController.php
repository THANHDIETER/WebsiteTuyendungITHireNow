<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Hiển thị danh sách báo cáo
    public function index()
    {
        $reports = Report::with(['reporter', 'target'])
            ->latest()
            ->paginate(10);

        return view('admin.reports.index', compact('reports'));
    }

    // Chi tiết một báo cáo
    public function show(Report $report)
    {
        if (!$report->seen_at) {
            $report->update(['seen_at' => now()]);
        }

        return view('admin.reports.show', compact('report'));
    }

    // Cập nhật trạng thái báo cáo
    public function update(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_note' => 'nullable|string|max:1000',
        ]);

        $report->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note,
            'resolved_by' => auth()->id(),
        ]);

        return redirect()->route('admin.reports.index')->with('success', 'Đã cập nhật trạng thái báo cáo.');
    }

    // Xóa báo cáo
    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->back()->with('success', 'Đã xóa báo cáo.');
    }
}
