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
            $keyword = trim($request->keyword);

            if (preg_match('/^0+$/', $keyword) || is_numeric($keyword)) {
                $query->where('id', intval($keyword));
            } else {
                // Chuẩn hóa keyword: viết hoa và loại bỏ khoảng trắng
                $normalizedKeyword = strtoupper(preg_replace('/\s+/', '', $keyword));

                $query->where(function ($q) use ($normalizedKeyword) {
                    $q->whereRaw("REPLACE(UPPER(trans_id), ' ', '') LIKE ?", ["%{$normalizedKeyword}%"])
                        ->orWhereRaw("REPLACE(UPPER(description), ' ', '') LIKE ?", ["%{$normalizedKeyword}%"])
                        ->orWhereRaw("REPLACE(UPPER(type), ' ', '') LIKE ?", ["%{$normalizedKeyword}%"])
                        ->orWhereHas('bankAccount', function ($bq) use ($normalizedKeyword) {
                            $bq->whereRaw("REPLACE(UPPER(bank), ' ', '') LIKE ?", ["%{$normalizedKeyword}%"])
                                ->orWhereRaw("REPLACE(UPPER(account_number), ' ', '') LIKE ?", ["%{$normalizedKeyword}%"])
                                ->orWhereRaw("REPLACE(UPPER(branch), ' ', '') LIKE ?", ["%{$normalizedKeyword}%"]);
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
