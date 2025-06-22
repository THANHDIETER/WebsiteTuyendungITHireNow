<?php

namespace App\Http\Controllers\Admin;

use App\Models\BankLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankLogController extends Controller
{
    public function index(Request $request)
    {
       $title = 'Danh sách giao dịch ngân hàng';
       return view('admin.bank_logs.index', compact('title'));
       
    }
}
