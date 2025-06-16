<?php

namespace App\Http\Controllers\Api;

use App\Models\BankLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankLogController extends Controller
{
    public function index(Request $request)
    {
        $query = BankLog::with('bankAccount');

        // Lọc theo bank_account_id nếu có
        if ($request->filled('bank_account_id')) {
            $query->where('bank_account_id', $request->bank_account_id);
        }

        // Tìm theo keyword
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            // Nếu keyword toàn số 0 hoặc là số liên tiếp, tìm theo ID
            if (preg_match('/^0+$/', $keyword) || is_numeric($keyword)) {
                $query->where('id', intval($keyword));
            } else {
                $kw = '%' . $keyword . '%';

                $query->where(function ($q) use ($kw) {
                    $q->where('trans_id', 'like', $kw)
                        ->orWhere('description', 'like', $kw)
                        ->orWhere('type', 'like', $kw)
                        ->orWhereHas('bankAccount', function ($bq) use ($kw) {
                            $bq->where('bank', 'like', $kw)
                                ->orWhere('account_number', 'like', $kw)
                                ->orWhere('branch', 'like', $kw);
                        });
                });
            }
        }

        $perPage = $request->input('per_page', 10);

        return response()->json(
            $query->orderByDesc('trans_time')->paginate($perPage)
        );
    }


}
