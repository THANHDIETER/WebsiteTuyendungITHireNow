<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BankAccountControlle extends Controller
{

    public function index()
    {
        $title = 'Quản lý tài khoản ngân hàng';
        return view('admin.bank_accounts.index', compact('title'));
    }
}
